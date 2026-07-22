<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Question;
use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'id');
$tags = Question::whereNotNull('topic_tag')->pluck('topic_tag')->unique();

$enJson = json_decode(file_get_contents('lang/en.json'), true);
$idJson = json_decode(file_get_contents('lang/id.json'), true);

foreach ($tags as $tag) {
    if (!isset($enJson[$tag])) {
        try {
            $translated = $tr->translate($tag);
            $enJson[$tag] = $translated;
            $idJson[$tag] = $tag;
            echo "Added topic tag translation: '{$tag}' => '{$translated}'\n";
        } catch (\Exception $e) {
            echo "Error translating tag '{$tag}': " . $e->getMessage() . "\n";
        }
    }
}

file_put_contents('lang/en.json', json_encode($enJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents('lang/id.json', json_encode($idJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Done updating topic tags in lang files!\n";
