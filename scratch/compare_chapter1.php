<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$maxModuleId = DB::table('modules')->max('id');

DB::beginTransaction();

try {
    app(Database\Seeders\Chapter1Seeder::class)->run();

    $rows = DB::table('modules')
        ->where('chapter_id', 1)
        ->where('id', '>', $maxModuleId)
        ->orderBy('order')
        ->get(['id', 'order', 'title', 'content', 'image_path']);

    foreach ($rows as $row) {
        $title = json_decode($row->title, true);
        $content = json_decode($row->content, true);
        echo 'order=' . $row->order
            . ' title_id=' . hash('sha256', $title['id'] ?? '')
            . ' content_id=' . hash('sha256', $content['id'] ?? '')
            . ' content_id_len=' . strlen($content['id'] ?? '')
            . ' image=' . ($row->image_path ?? '') . PHP_EOL;
    }
} finally {
    DB::rollBack();
}
