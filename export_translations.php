<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$modules = \App\Models\Module::all();
$arrayExport = "        \$englishContent = [\n";

foreach ($modules as $module) {
    $titleId = $module->getTranslation('title', 'id');
    $contentEn = $module->getTranslation('content', 'en');
    
    // Escape single quotes and backslashes for PHP array syntax
    if (!empty($contentEn) && $contentEn !== $module->getTranslation('content', 'id')) {
        $escapedContent = addcslashes($contentEn, "'\\");
        // Keep actual line breaks so the generated seeder remains readable.
        $escapedContent = str_replace("\r", "", $escapedContent);
        $escapedContent = preg_replace('/>\s*</', ">\n<", $escapedContent);
        $escapedContent = preg_replace_callback(
            '/(?<=>)[^<\r\n]{101,}(?=<)/',
            fn ($match) => wordwrap(trim($match[0]), 100, "\n"),
            $escapedContent
        );
        
        $arrayExport .= "            '" . addcslashes($titleId, "'\\") . "' => '" . $escapedContent . "',\n";
    }
}

$arrayExport .= "        ];\n\n";

$seederPath = __DIR__ . '/database/seeders/EnglishContentSeeder.php';
$seederContent = file_get_contents($seederPath);

// Replace the entire content-override array, regardless of which chapters
// have already been exported. This includes all modules from Chapter 1 through Chapter 7.
$pattern = '/\$englishContent\s*=\s*\[.*?^\s*\];\s*(?=\/\/ --- Chapter Titles \(EN\) ---)/ms';
if (preg_match($pattern, $seederContent)) {
    $newSeederContent = preg_replace($pattern, $arrayExport, $seederContent);
    file_put_contents($seederPath, $newSeederContent);
    echo "Berhasil mengekspor terjemahan ke EnglishContentSeeder.php!\n";
} else {
    echo "GAGAL: Tidak dapat menemukan array \$englishContent di seeder.\n";
}
