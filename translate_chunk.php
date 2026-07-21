<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'id');

$modules = \App\Models\Module::all();
$limit = 10; // Hanya translate 3 modul sekali jalan agar tidak kena block
$count = 0;

$failedData = json_decode(file_get_contents('failed_translations.json'), true);

echo "Mencoba menerjemahkan maksimal $limit modul...\n";

foreach ($modules as $module) {
    $titleId = $module->getTranslation('title', 'id');
    
    // Cek apakah modul ini belum ada terjemahannya (ada di failed_translations)
    if (isset($failedData[$titleId])) {
        $contentId = $module->getTranslation('content', 'id');
        $contentEn = $module->getTranslation('content', 'en');
        
        // Pastikan di database memang belum diterjemahkan
        if (empty($contentEn) || $contentEn === $contentId) {
            echo "Menerjemahkan: " . $titleId . "...\n";
            
            try {
                $translatedContent = "";
                $parts = preg_split('/(<\/p>|<\/li>|<\/div>|<br>|<br\/>)/i', $contentId, -1, PREG_SPLIT_DELIM_CAPTURE);
                
                foreach ($parts as $part) {
                    if (trim(strip_tags($part)) === '') {
                        $translatedContent .= $part;
                    } else {
                        $translatedContent .= $tr->translate($part);
                        sleep(2); // Jeda 2 detik per kalimat
                    }
                }
                
                $module->setTranslation('content', 'en', $translatedContent);
                $module->save();
                
                // Hapus dari failed_translations.json agar tidak diulang next time
                unset($failedData[$titleId]);
                file_put_contents('failed_translations.json', json_encode($failedData, JSON_PRETTY_PRINT));
                
                echo "  -> Berhasil!\n";
                $count++;
                
                if ($count >= $limit) {
                    echo "\nBerhasil menerjemahkan $limit modul. Sisa yang belum: " . count($failedData) . "\n";
                    echo "Silakan jalankan script ini lagi nanti untuk menyicil sisa modul.\n";
                    break;
                }
                
                sleep(5); // Jeda 5 detik antar modul
                
            } catch (\Exception $e) {
                echo "  -> GAGAL (Mungkin masih terblokir). Pesan: " . $e->getMessage() . "\n";
                break; // Stop jika error agar tidak buang waktu
            }
        }
    }
}

if ($count === 0) {
    echo "Tidak ada modul yang berhasil diterjemahkan atau semua sudah selesai.\n";
}
