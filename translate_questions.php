<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Question;
use App\Models\QuestionOption;
use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'id');

$questions = Question::all();
echo "Total questions: " . $questions->count() . "\n";

$updatedQ = 0;
$updatedOpt = 0;

foreach ($questions as $q) {
    $qTextId = $q->getTranslation('question_text', 'id');
    $qTextEn = $q->getTranslation('question_text', 'en');

    $explId = $q->getTranslation('explanation', 'id');
    $explEn = $q->getTranslation('explanation', 'en');

    $needsQUpdate = false;
    $rawQText = $q->getRawOriginal('question_text');
    $qArray = is_string($rawQText) ? json_decode($rawQText, true) : [];
    if (!is_array($qArray)) {
        $qArray = ['id' => $rawQText, 'en' => ''];
    }

    if (empty($qArray['en']) && !empty($qArray['id'])) {
        try {
            $qArray['en'] = $tr->translate($qArray['id']);
            $needsQUpdate = true;
            echo "Translated Question #{$q->id}: {$qArray['en']}\n";
        } catch (\Exception $e) {
            echo "Error translating Q #{$q->id}: " . $e->getMessage() . "\n";
        }
    }

    $rawExpl = $q->getRawOriginal('explanation');
    $explArray = is_string($rawExpl) ? json_decode($rawExpl, true) : [];
    if (!is_array($explArray)) {
        $explArray = ['id' => $rawExpl, 'en' => ''];
    }

    if (!empty($explArray['id']) && empty($explArray['en'])) {
        try {
            $explArray['en'] = $tr->translate($explArray['id']);
            $needsQUpdate = true;
        } catch (\Exception $e) {}
    }

    if ($needsQUpdate) {
        $q->update([
            'question_text' => $qArray,
            'explanation' => $explArray,
        ]);
        $updatedQ++;
    }

    foreach ($q->options as $opt) {
        $rawOpt = $opt->getRawOriginal('option_text');
        $optArray = is_string($rawOpt) ? json_decode($rawOpt, true) : [];
        if (!is_array($optArray)) {
            $optArray = ['id' => $rawOpt, 'en' => ''];
        }

        $rawMatch = $opt->getRawOriginal('match_label');
        $matchArray = is_string($rawMatch) ? json_decode($rawMatch, true) : [];
        if (!is_array($matchArray)) {
            $matchArray = ['id' => $rawMatch, 'en' => ''];
        }

        $needsOptUpdate = false;

        if (!empty($optArray['id']) && empty($optArray['en'])) {
            try {
                $optArray['en'] = $tr->translate($optArray['id']);
                $needsOptUpdate = true;
            } catch (\Exception $e) {}
        }

        if (!empty($matchArray['id']) && empty($matchArray['en'])) {
            try {
                $matchArray['en'] = $tr->translate($matchArray['id']);
                $needsOptUpdate = true;
            } catch (\Exception $e) {}
        }

        if ($needsOptUpdate) {
            $opt->update([
                'option_text' => $optArray,
                'match_label' => $matchArray,
            ]);
            $updatedOpt++;
        }
    }
}

echo "Done! Updated {$updatedQ} questions and {$updatedOpt} options.\n";
