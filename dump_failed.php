<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$modules = \App\Models\Module::all();
$failed = [];
foreach ($modules as $module) {
    $contentId = $module->getTranslation('content', 'id');
    $contentEn = $module->getTranslation('content', 'en');
    
    if (empty($contentEn) || $contentEn === $contentId) {
        $failed[$module->getTranslation('title', 'id')] = $contentId;
    }
}

file_put_contents('failed_translations.json', json_encode($failed, JSON_PRETTY_PRINT));
echo "Dumped " . count($failed) . " failed modules to failed_translations.json\n";
