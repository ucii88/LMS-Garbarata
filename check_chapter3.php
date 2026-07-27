<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Chapter;
use App\Models\Module;

$chapters = Chapter::with('modules')->get();
foreach ($chapters as $ch) {
    echo "Chapter {$ch->order}: {$ch->title}\n";
    foreach ($ch->modules as $m) {
        $titleId = $m->getTranslation('title', 'id');
        $titleEn = $m->getTranslation('title', 'en');
        echo "  - Mod {$m->order}: ID='{$titleId}' | EN='{$titleEn}'\n";
    }
}
