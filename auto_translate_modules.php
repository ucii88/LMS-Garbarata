<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

function translateText($text) {
    if (empty(trim($text))) return $text;
    
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=id&tl=en&dt=t";
    $postData = http_build_query(['q' => $text]);
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $postData,
            'timeout' => 10,
        ],
    ];
    
    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        return false;
    }
    
    $data = json_decode($response, true);
    $translated = "";
    if (isset($data[0])) {
        foreach ($data[0] as $part) {
            $translated .= $part[0];
        }
    }
    return $translated;
}

$modules = \App\Models\Module::all();
$successCount = 0;
$failCount = 0;

echo "Mulai menerjemahkan " . $modules->count() . " modul...\n";

foreach ($modules as $module) {
    $contentId = $module->getTranslation('content', 'id');
    $contentEn = $module->getTranslation('content', 'en');
    
    // Hanya terjemahkan jika EN kosong atau sama persis dengan ID
    if (!empty(trim($contentId)) && (empty($contentEn) || $contentEn === $contentId)) {
        echo "Menerjemahkan: " . $module->getTranslation('title', 'id') . "...\n";
        
        // Chunk translation if it's too big (rough limit 4000 chars)
        // For HTML, chunking by block might be better, but let's try direct first.
        if (strlen($contentId) > 4000) {
             // Split by double newline roughly
             $parts = explode("\n\n", $contentId);
             $translatedContent = "";
             foreach ($parts as $part) {
                 if (empty(trim($part))) {
                     $translatedContent .= "\n\n";
                     continue;
                 }
                 $res = translateText($part);
                 if ($res === false) {
                     echo "  -> Gagal pada sebagian konten (Rate Limit?). Menunggu 5 detik...\n";
                     sleep(5);
                     $res = translateText($part); // retry
                     if ($res === false) {
                         $translatedContent .= $part; // fallback to original
                     } else {
                         $translatedContent .= $res . "\n\n";
                     }
                 } else {
                     $translatedContent .= $res . "\n\n";
                 }
                 usleep(500000); // 0.5s delay
             }
        } else {
             $translatedContent = translateText($contentId);
             if ($translatedContent === false) {
                 echo "  -> Gagal (Rate Limit?). Menunggu 5 detik...\n";
                 sleep(5);
                 $translatedContent = translateText($contentId);
             }
        }
        
        if ($translatedContent) {
            $module->setTranslation('content', 'en', $translatedContent);
            $module->save();
            echo "  -> Berhasil!\n";
            $successCount++;
        } else {
            echo "  -> GAGAL (Mungkin kena block dari Google API).\n";
            $failCount++;
        }
        
        sleep(1); // 1 second delay between modules to prevent rate limiting
    } else {
        // Skip if already translated properly
        // echo "Melewati: " . $module->getTranslation('title', 'id') . " (Sudah diterjemahkan)\n";
    }
}

echo "\nSelesai! Berhasil: $successCount, Gagal: $failCount\n";
