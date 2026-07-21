<?php

$text = "<p><strong>Rotunda</strong> dirancang sebagai pusat sumbu untuk gerakan vertikal dan horizontal Garbarata.</p>";
$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=id&tl=en&dt=t&q=" . urlencode($text);

$response = file_get_contents($url);
$data = json_decode($response, true);
$translated = "";
if (isset($data[0])) {
    foreach ($data[0] as $part) {
        $translated .= $part[0];
    }
}
echo "Original: $text\n";
echo "Translated: $translated\n";
