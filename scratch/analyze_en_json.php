<?php

$filePath = '/Applications/XAMPP/xamppfiles/htdocs/LMS-Garbarata/lang/en.json';
$rawContent = file_get_contents($filePath);

$lines = explode("\n", $rawContent);
$keysSeen = [];
$duplicates = [];

foreach ($lines as $idx => $line) {
    $lineNum = $idx + 1;
    if (preg_match('/^\s*"((?:[^"\\\\]|\\\\.)*)"\s*:\s*"/U', $line, $match)) {
        $key = stripcslashes($match[1]);
        if (isset($keysSeen[$key])) {
            $duplicates[$key][] = $lineNum;
            if (count($duplicates[$key]) === 1) {
                array_unshift($duplicates[$key], $keysSeen[$key]);
            }
        } else {
            $keysSeen[$key] = $lineNum;
        }
    }
}

echo "=== PERFECT DUPLICATE KEYS ANALYSIS ===\n";
echo "Total distinct keys: " . count($keysSeen) . "\n";
echo "Total duplicate keys found: " . count($duplicates) . "\n";

foreach ($duplicates as $key => $lineNumbers) {
    echo "  - \"{$key}\" on lines: " . implode(', ', $lineNumbers) . "\n";
}

$decoded = json_decode($rawContent, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo "JSON Status: VALID JSON with exactly " . count($decoded) . " unique entries.\n";
} else {
    echo "JSON Status: INVALID - " . json_last_error_msg() . "\n";
}
