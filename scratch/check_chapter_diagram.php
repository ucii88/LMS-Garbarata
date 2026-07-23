<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$chapter = App\Models\Chapter::with('diagram.hotspots')->find(5);
echo "Chapter 5 ID: " . $chapter->id . " Title: " . $chapter->title . PHP_EOL;
echo "Chapter Diagram ID: " . ($chapter->diagram ? $chapter->diagram->id : 'NONE') . PHP_EOL;
if ($chapter->diagram) {
    echo "  Image Path: " . $chapter->diagram->image_path . PHP_EOL;
    echo "  Title: " . $chapter->diagram->title . PHP_EOL;
    echo "  Hotspots count: " . $chapter->diagram->hotspots->count() . PHP_EOL;
    foreach ($chapter->diagram->hotspots as $h) {
        echo "    - Hotspot " . $h->label . ": x=" . $h->x_percent . "%, y=" . $h->y_percent . "%, title=" . $h->popup_title . PHP_EOL;
    }
}
