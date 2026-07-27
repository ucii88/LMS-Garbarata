<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Quiz;

$quizzes = Quiz::all();
foreach ($quizzes as $q) {
    echo "ID: {$q->id} | Type: " . ($q->is_practice ? 'Practice' : 'Quiz') . " | Title (id): {$q->getTranslation('title', 'id')} | Title (en): {$q->getTranslation('title', 'en', false)}\n";
}
