<?php
function translateText($text) {
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=id&tl=en&dt=t";
    $postData = http_build_query(['q' => $text]);
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $postData,
        ],
    ];
    
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
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

$text = "<p><strong>Rotunda</strong> dirancang sebagai pusat sumbu untuk gerakan vertikal dan horizontal Garbarata. Ini adalah teks panjang yang dikirim via POST.</p>";
echo "Translated: " . translateText($text) . "\n";
