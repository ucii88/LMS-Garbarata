<?php

$filePath = '/Applications/XAMPP/xamppfiles/htdocs/LMS-Garbarata/lang/en.json';
$data = json_decode(file_get_contents($filePath), true);

$newKeys = [
    "Sedang Dikerjakan" => "In Progress",
    "Yakin submit quiz?" => "Are you sure you want to submit?",
    "soal belum terjawab. Soal yang belum dijawab tidak akan mendapat poin." => "questions unanswered. Unanswered questions will receive no points.",
    "Semua soal sudah dijawab." => "All questions have been answered.",
    "Ya, Submit" => "Yes, Submit",
    "Latihan Chapter" => "Chapter Practice",
    "Ujian — Ujian Akhir" => "Exam — Final Exam",
    "Soal" => "Questions",
    "Waktu" => "Time",
    "Tanpa Batas Nilai" => "No Passing Mark",
    "Nilai Lulus" => "Passing Mark",
    "Sisa Percobaan" => "Remaining Attempts",
    "Percobaan Terakhir: Skor" => "Last Attempt: Score",
    "Perhatikan sebelum mulai:" => "Please note before starting:",
    "Jawaban tersimpan otomatis." => "Answers are saved automatically.",
    "Percobaan tanpa batas." => "Unlimited attempts.",
    "Latihan dapat ditinggalkan lalu dilanjutkan kembali, dan tidak memengaruhi progres atau sertifikat." => "Practice can be left and resumed later, and does not affect progress or certificate.",
    "Nilai kelulusan minimum:" => "Minimum passing mark:",
    "Latihan Lagi" => "Try Practice Again",
    "Mulai Latihan" => "Start Practice",
    "Coba Lagi" => "Try Again",
    "Mulai Quiz" => "Start Quiz",
    "Batas Percobaan Habis" => "No Remaining Attempts",
    "Jadwal Akses Quiz" => "Quiz Access Schedule",
    "Dibuka:" => "Opens at:",
    "Ditutup:" => "Closes at:"
];

foreach ($newKeys as $k => $v) {
    $data[$k] = $v;
}

$cleanJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($filePath, $cleanJson);

echo "Successfully updated lang/en.json cleanly with " . count($data) . " entries.\n";
