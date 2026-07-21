<?php
$jsonFiles = [
    'en' => __DIR__ . '/lang/en.json',
    'id' => __DIR__ . '/lang/id.json',
];

$translations = [
    'Progress Belajar Peserta' => ['en' => 'Participant Learning Progress', 'id' => 'Progress Belajar Peserta'],
    'Pantau perkembangan peserta dalam menyelesaikan modul dan bab pembelajaran.' => ['en' => 'Monitor participant progress in completing modules and learning chapters.', 'id' => 'Pantau perkembangan peserta dalam menyelesaikan modul dan bab pembelajaran.'],
    'Nama Peserta' => ['en' => 'Participant Name', 'id' => 'Nama Peserta'],
    'Email' => ['en' => 'Email', 'id' => 'Email'],
    'Progress Keseluruhan' => ['en' => 'Overall Progress', 'id' => 'Progress Keseluruhan'],
    'Detail' => ['en' => 'Detail', 'id' => 'Detail'],
    'Lihat Detail' => ['en' => 'View Detail', 'id' => 'Lihat Detail'],
    'Belum ada peserta yang terdaftar.' => ['en' => 'No participants registered yet.', 'id' => 'Belum ada peserta yang terdaftar.'],
    'Tidak ada jadwal mendatang untuk minggu ini.' => ['en' => 'No upcoming schedule for this week.', 'id' => 'Tidak ada jadwal mendatang untuk minggu ini.'],
    'Lihat Kalender Lengkap' => ['en' => 'View Full Calendar', 'id' => 'Lihat Kalender Lengkap'],
    'Belum ada latihan' => ['en' => 'No exercises yet', 'id' => 'Belum ada latihan'],
    'Belum ada quiz' => ['en' => 'No quizzes yet', 'id' => 'Belum ada quiz'],
    'Buat latihan pertama untuk course ini.' => ['en' => 'Create the first exercise for this course.', 'id' => 'Buat latihan pertama untuk course ini.'],
    'Buat quiz pertama untuk course ini.' => ['en' => 'Create the first quiz for this course.', 'id' => 'Buat quiz pertama untuk course ini.'],
    'LATIHAN' => ['en' => 'EXERCISE', 'id' => 'LATIHAN'],
    'FINAL' => ['en' => 'FINAL', 'id' => 'FINAL'],
    'KUIS' => ['en' => 'QUIZ', 'id' => 'KUIS'],
    'Non-aktif' => ['en' => 'Inactive', 'id' => 'Non-aktif'],
    'Latihan Chapter:' => ['en' => 'Chapter Exercise:', 'id' => 'Latihan Chapter:'],
    'Final Quiz (Ujian Akhir Course)' => ['en' => 'Final Quiz (Course Final Exam)', 'id' => 'Final Quiz (Ujian Akhir Course)'],
    'Chapter Quiz:' => ['en' => 'Chapter Quiz:', 'id' => 'Chapter Quiz:'],
    'soal' => ['en' => 'questions', 'id' => 'soal'],
    'Tanpa timer' => ['en' => 'No timer', 'id' => 'Tanpa timer'],
    'Maks.' => ['en' => 'Max.', 'id' => 'Maks.'],
    'percobaan' => ['en' => 'attempts', 'id' => 'percobaan'],
    'Tanpa batas percobaan' => ['en' => 'Unlimited attempts', 'id' => 'Tanpa batas percobaan'],
    'Lulus:' => ['en' => 'Passing grade:', 'id' => 'Lulus:'],
    'mnt' => ['en' => 'min', 'id' => 'mnt'],
    'Publish Latihan' => ['en' => 'Publish Exercise', 'id' => 'Publish Latihan'],
    'Publish Ujian' => ['en' => 'Publish Exam', 'id' => 'Publish Ujian'],
    'Publish Quiz' => ['en' => 'Publish Quiz', 'id' => 'Publish Quiz'],
    'Hasil Peserta' => ['en' => 'Participant Results', 'id' => 'Hasil Peserta'],
    'Edit & Kelola Soal' => ['en' => 'Edit & Manage Questions', 'id' => 'Edit & Kelola Soal'],
    'Hapus' => ['en' => 'Delete', 'id' => 'Hapus'],
    'Hapus latihan ini?' => ['en' => 'Delete this exercise?', 'id' => 'Hapus latihan ini?'],
    'Hapus quiz ini?' => ['en' => 'Delete this quiz?', 'id' => 'Hapus quiz ini?'],
];

foreach ($jsonFiles as $lang => $path) {
    if (file_exists($path)) {
        $data = json_decode(file_get_contents($path), true) ?: [];
        foreach ($translations as $key => $trans) {
            if (!isset($data[$key])) {
                $data[$key] = $trans[$lang];
            }
        }
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Updated $path\n";
    }
}
