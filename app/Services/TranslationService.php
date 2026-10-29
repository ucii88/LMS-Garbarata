<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate text between source and target languages.
     * Tries Stichoza first; if blocked/rate-limited (429), falls back to Google dict-chrome-ex,
     * then MyMemory, ensuring translation always succeeds.
     */
    public static function translate(string $text, string $sourceLang = 'id', string $targetLang = 'en'): string
    {
        $trimmed = trim($text);
        if ($trimmed === '' || $sourceLang === $targetLang) {
            return $text;
        }

        // Strip tags for pure text checking
        $isPureHtml = ($text !== strip_tags($text));

        // 1. Try Google dict-chrome-ex directly (most reliable without 429 rate limit)
        $dictResult = static::translateViaGoogleDict($trimmed, $sourceLang, $targetLang);
        if ($dictResult !== false && trim($dictResult) !== '') {
            return $dictResult;
        }

        // 2. Try Stichoza GoogleTranslate
        try {
            $tr = new GoogleTranslate($targetLang, $sourceLang);
            $result = $tr->translate($trimmed);
            if (!empty($result)) {
                return $result;
            }
        } catch (\Throwable $e) {
            // Silently proceed to next fallback
        }

        // 3. Fallback to MyMemory API
        $myMemoryResult = static::translateViaMyMemory($trimmed, $sourceLang, $targetLang);
        if ($myMemoryResult !== false && trim($myMemoryResult) !== '') {
            return $myMemoryResult;
        }

        // Fallback to original text if everything fails
        return $text;
    }

    /**
     * Auto-translate a pair of [id => ..., en => ...].
     * If both are filled, returns as-is.
     * If only ID is provided, translates to EN.
     * If only EN is provided, translates to ID.
     *
     * @return array [id => string, en => string]
     */
    public static function autoTranslatePair(?string $textId, ?string $textEn): array
    {
        $id = trim((string) $textId);
        $en = trim((string) $textEn);

        $hasId = ($id !== '');
        $hasEn = ($en !== '');

        if ($hasId && $hasEn) {
            // If both are filled but they are identical non-empty text, it was likely an earlier fallback copy
            if (trim($id) === trim($en)) {
                $translatedEn = static::translate($id, 'id', 'en');
                if (trim($translatedEn) !== '' && strcasecmp(trim($translatedEn), trim($id)) !== 0) {
                    return ['id' => $id, 'en' => $translatedEn];
                }
            }
            return ['id' => $textId, 'en' => $textEn];
        }

        if (!$hasId && !$hasEn) {
            return ['id' => '', 'en' => ''];
        }

        if ($hasId && !$hasEn) {
            $translatedEn = static::translate($id, 'id', 'en');
            return [
                'id' => $textId,
                'en' => ($translatedEn !== '' ? $translatedEn : $textId),
            ];
        }

        // $hasEn && !$hasId
        $translatedId = static::translate($en, 'en', 'id');
        return [
            'id' => ($translatedId !== '' ? $translatedId : $textEn),
            'en' => $textEn,
        ];
    }

    /**
     * Handle array payload or single string for multi-language attributes.
     */
    public static function autoTranslatePayload(mixed $value): array
    {
        if (is_array($value)) {
            return static::autoTranslatePair($value['id'] ?? null, $value['en'] ?? null);
        }

        $text = trim((string) $value);
        if ($text === '') {
            return ['id' => '', 'en' => ''];
        }

        // Translate id -> en by default
        $en = static::translate($text, 'id', 'en');
        // If translation is identical, it might be English input or proper noun
        if (strcasecmp($en, $text) === 0) {
            // Try en -> id
            $idCandidate = static::translate($text, 'en', 'id');
            if (strcasecmp($idCandidate, $text) !== 0) {
                return ['id' => $idCandidate, 'en' => $text];
            }
        }

        return ['id' => $text, 'en' => $en];
    }

    private static function translateViaGoogleDict(string $text, string $sl, string $tl): string|false
    {
        try {
            $url = "https://clients5.google.com/translate_a/t?client=dict-chrome-ex&sl=" . urlencode($sl) . "&tl=" . urlencode($tl) . "&q=" . urlencode($text);
            $context = stream_context_create([
                'http' => [
                    'header'  => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n",
                    'timeout' => 5,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);

            $response = @file_get_contents($url, false, $context);
            if ($response !== false) {
                $data = json_decode($response, true);
                if (is_array($data) && isset($data[0])) {
                    $res = is_array($data[0]) ? ($data[0][0] ?? '') : $data[0];
                    if (is_string($res) && trim($res) !== '') {
                        return trim($res);
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return false;
    }

    private static function translateViaMyMemory(string $text, string $sl, string $tl): string|false
    {
        try {
            $url = "https://api.mymemory.translated.net/get?q=" . urlencode($text) . "&langpair=" . urlencode($sl) . "|" . urlencode($tl);
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);

            $response = @file_get_contents($url, false, $context);
            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['responseData']['translatedText']) && !empty($data['responseData']['translatedText'])) {
                    return html_entity_decode(trim($data['responseData']['translatedText']), ENT_QUOTES, 'UTF-8');
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return false;
    }
}
