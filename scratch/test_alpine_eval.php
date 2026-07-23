<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(1);
auth()->login($user);

app()->setLocale('id');

$course = App\Models\Course::find(1);
$chapterId = 5;

$controller = app(App\Http\Controllers\CourseController::class);
$view = $controller->showChapter($course, $chapterId);
$html = $view->render();

// Find hotspot button tag
preg_match_all('/<button[^>]*clickHotspot[^>]*>/', $html, $matches);
echo "Found " . count($matches[0]) . " hotspot buttons in HTML:" . PHP_EOL;
for ($i = 0; $i < min(3, count($matches[0])); $i++) {
    echo "Button " . ($i + 1) . ": " . $matches[0][$i] . PHP_EOL;
}
