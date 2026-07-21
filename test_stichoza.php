<?php
require __DIR__ . '/vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    $tr = new GoogleTranslate('en', 'id');
    echo $tr->translate("Halo dunia! Apakah API sudah bisa dipakai?");
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
