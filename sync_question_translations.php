<?php

function envValue(string $key): ?string
{
    $envFile = __DIR__ . '/.env';
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = explode('=', $line, 2);
        if (trim($k) === $key) {
            return trim($v, "\"' ");
        }
    }
    return null;
}

$rows = json_decode(file_get_contents(__DIR__ . '/translated_questions.json'), true);
if (!is_array($rows)) {
    fwrite(STDERR, "Invalid translated_questions.json\n");
    exit(1);
}

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    envValue('DB_HOST') ?: '127.0.0.1',
    envValue('DB_PORT') ?: '3306',
    envValue('DB_DATABASE') ?: ''
);

$pdo = new PDO($dsn, envValue('DB_USERNAME') ?: 'root', envValue('DB_PASSWORD') ?: '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$questionStmt = $pdo->prepare('UPDATE questions SET question_text = ?, explanation = ?, updated_at = NOW() WHERE id = ?');
$optionStmt = $pdo->prepare('UPDATE question_options SET option_text = ?, match_label = ?, updated_at = NOW() WHERE id = ?');

$updatedQuestions = 0;
$updatedOptions = 0;

foreach ($rows as $row) {
    if (empty($row['id'])) {
        continue;
    }

    $questionStmt->execute([
        $row['question_text'] ?? null,
        $row['explanation'] ?? null,
        $row['id'],
    ]);
    $updatedQuestions++;

    foreach (($row['options'] ?? []) as $optRow) {
        if (empty($optRow['id'])) {
            continue;
        }

        $optionStmt->execute([
            $optRow['option_text'] ?? null,
            $optRow['match_label'] ?? null,
            $optRow['id'],
        ]);
        $updatedOptions++;
    }
}

echo "Updated {$updatedQuestions} questions and {$updatedOptions} options.\n";
