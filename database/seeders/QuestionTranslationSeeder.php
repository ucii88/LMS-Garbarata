<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Stichoza\GoogleTranslate\GoogleTranslate;

class QuestionTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translator = new GoogleTranslate('en', 'id');
        $updatedQuestions = 0;
        $updatedOptions = 0;

        foreach (Question::with('options')->get() as $question) {
            $questionChanged = false;
            $questionText = $this->locales($question->getRawOriginal('question_text'));
            $explanation = $this->locales($question->getRawOriginal('explanation'));

            if (!empty($questionText['id']) && empty($questionText['en'])) {
                $questionText['en'] = $translator->translate($questionText['id']);
                $questionChanged = true;
            }
            if (!empty($explanation['id']) && empty($explanation['en'])) {
                $explanation['en'] = $translator->translate($explanation['id']);
                $questionChanged = true;
            }
            if ($questionChanged) {
                $question->update([
                    'question_text' => $questionText,
                    'explanation' => $explanation,
                ]);
                $updatedQuestions++;
            }

            foreach ($question->options as $option) {
                $optionChanged = false;
                $optionText = $this->locales($option->getRawOriginal('option_text'));
                $rawMatchLabel = $option->getRawOriginal('match_label');
                $matchLabel = $this->locales($rawMatchLabel);

                if (!empty($optionText['id']) && empty($optionText['en'])) {
                    $optionText['en'] = $translator->translate($optionText['id']);
                    $optionChanged = true;
                }
                if (!empty($matchLabel['id']) && empty($matchLabel['en'])) {
                    $matchLabel['en'] = $translator->translate($matchLabel['id']);
                    $optionChanged = true;
                }
                if ($optionChanged) {
                    $option->update([
                        'option_text' => $optionText,
                        'match_label' => $matchLabel,
                    ]);
                    $updatedOptions++;
                }
            }
        }

        $this->command?->info("Translated {$updatedQuestions} questions and {$updatedOptions} options.");
    }

    private function locales($value): array
    {
        if (is_array($value)) {
            return ['id' => (string) ($value['id'] ?? ''), 'en' => (string) ($value['en'] ?? '')];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return ['id' => (string) ($decoded['id'] ?? ''), 'en' => (string) ($decoded['en'] ?? '')];
            }
            return ['id' => $value, 'en' => ''];
        }
        return ['id' => '', 'en' => ''];
    }
}
