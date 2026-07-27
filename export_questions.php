<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Question;

$questions = Question::with('options')->get();

$exportData = [];
foreach ($questions as $q) {
    $qData = [
        'id' => $q->id,
        'chapter_id' => $q->chapter_id,
        'question_text' => $q->getRawOriginal('question_text'),
        'explanation' => $q->getRawOriginal('explanation'),
        'options' => []
    ];
    foreach ($q->options as $opt) {
        $qData['options'][] = [
            'id' => $opt->id,
            'option_text' => $opt->getRawOriginal('option_text'),
            'match_label' => $opt->getRawOriginal('match_label'),
        ];
    }
    $exportData[] = $qData;
}

file_put_contents('translated_questions.json', json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Successfully exported " . count($exportData) . " questions to translated_questions.json!\n";
