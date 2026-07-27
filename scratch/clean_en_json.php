<?php

$filePath = '/Applications/XAMPP/xamppfiles/htdocs/LMS-Garbarata/lang/en.json';
$rawContent = file_get_contents($filePath);

// Remove trailing commas right before closing brace
$cleanedRaw = preg_replace('/,(\s*[\}\]])/', '$1', $rawContent);

$decoded = json_decode($cleanedRaw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error decoding JSON: " . json_last_error_msg() . "\n";
    exit(1);
}

$cleanArray = [];
foreach ($decoded as $key => $val) {
    if (strpos($key, "\n") !== false || strpos($key, "\r") !== false || trim($key) === '' || trim($key) === ',' || trim($key) === ':') {
        continue;
    }
    $cleanArray[$key] = $val;
}

$cleanJson = json_encode($cleanArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($filePath, $cleanJson);

echo "Successfully cleaned trailing comma! Total valid unique keys: " . count($cleanArray) . "\n";
