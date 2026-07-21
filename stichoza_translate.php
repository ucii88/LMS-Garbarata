<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'id'); // Translate from id to en

$modules = \App\Models\Module::all();
$successCount = 0;
$failCount = 0;

$failedData = json_decode(file_get_contents('failed_translations.json'), true);

echo "Mulai menerjemahkan " . count($failedData) . " modul gagal menggunakan Stichoza...\n";

foreach ($modules as $module) {
    $titleId = $module->getTranslation('title', 'id');
    
    if (isset($failedData[$titleId])) {
        $contentId = $module->getTranslation('content', 'id');
        echo "Menerjemahkan: " . $titleId . "...\n";
        
        try {
            $translatedContent = "";
            
            // To prevent large blocks failing, split by common HTML tags
            $parts = preg_split('/(<\/p>|<\/li>|<\/div>|<br>|<br\/>)/i', $contentId, -1, PREG_SPLIT_DELIM_CAPTURE);
            
            foreach ($parts as $part) {
                if (trim(strip_tags($part)) === '') {
                    $translatedContent .= $part; // Keep HTML tags and whitespace as is
                } else {
                    $translatedContent .= $tr->translate($part);
                    sleep(1); // Anti-rate limit
                }
            }
            
            $module->setTranslation('content', 'en', $translatedContent);
            $module->save();
            echo "  -> Berhasil!\n";
            $successCount++;
        } catch (\Exception $e) {
            echo "  -> GAGAL: " . $e->getMessage() . "\n";
            $failCount++;
            sleep(5); // Cool down on error
        }
    }
}

echo "\nSelesai! Berhasil: $successCount, Gagal: $failCount\n";
