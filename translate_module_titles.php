<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Module;
use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate('en', 'id');
$modules = Module::all();

$updated = 0;
foreach ($modules as $m) {
    $raw = $m->getRawOriginal('title');
    $titleArray = is_string($raw) ? json_decode($raw, true) : [];
    if (!is_array($titleArray)) {
        $titleArray = ['id' => $raw, 'en' => ''];
    }

    $idTitle = $titleArray['id'] ?? '';
    $enTitle = $titleArray['en'] ?? '';

    if (!empty($idTitle) && (empty($enTitle) || $enTitle === $idTitle)) {
        try {
            $translated = $tr->translate($idTitle);
            $titleArray['en'] = $translated;
            $m->update(['title' => $titleArray]);
            echo "Updated Mod #{$m->id}: ID='{$idTitle}' => EN='{$translated}'\n";
            $updated++;
        } catch (\Exception $e) {
            echo "Error Mod #{$m->id}: " . $e->getMessage() . "\n";
        }
    }
}

echo "Done! Updated {$updated} module titles.\n";
