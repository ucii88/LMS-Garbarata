<?php
$jsonFiles = [
    'en' => __DIR__ . '/lang/en.json',
    'id' => __DIR__ . '/lang/id.json',
];

$translations = [
    'Buat Latihan Baru' => ['en' => 'Create New Exercise', 'id' => 'Buat Latihan Baru'],
    'Buat Quiz Baru' => ['en' => 'Create New Quiz', 'id' => 'Buat Quiz Baru'],
    '← Kembali' => ['en' => '← Back', 'id' => '← Kembali'],
    'Judul *' => ['en' => 'Title *', 'id' => 'Judul *'],
    'Deskripsi' => ['en' => 'Description', 'id' => 'Deskripsi'],
    '-- Pilih chapter --' => ['en' => '-- Select chapter --', 'id' => '-- Pilih chapter --'],
    'Maks. percobaan (kosong = tanpa batas)' => ['en' => 'Max attempts (empty = unlimited)', 'id' => 'Maks. percobaan (kosong = tanpa batas)'],
    'Dibuka pada' => ['en' => 'Opens at', 'id' => 'Dibuka pada'],
    'Ditutup pada' => ['en' => 'Closes at', 'id' => 'Ditutup pada'],
    'Timer (menit)' => ['en' => 'Timer (minutes)', 'id' => 'Timer (menit)'],
    'Nilai lulus *' => ['en' => 'Passing score *', 'id' => 'Nilai lulus *'],
    'Maks. percobaan *' => ['en' => 'Max attempts *', 'id' => 'Maks. percobaan *'],
    'Tampilkan semua' => ['en' => 'Show all', 'id' => 'Tampilkan semua'],
    'Skor saja' => ['en' => 'Score only', 'id' => 'Skor saja'],
    'Sembunyikan detail' => ['en' => 'Hide details', 'id' => 'Sembunyikan detail'],
    'Acak soal' => ['en' => 'Shuffle questions', 'id' => 'Acak soal'],
    'Acak pilihan' => ['en' => 'Shuffle options', 'id' => 'Acak pilihan'],
    'Simpan & Pilih Soal' => ['en' => 'Save & Select Questions', 'id' => 'Simpan & Pilih Soal'],
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

// Now replace in create.blade.php
$createFile = __DIR__ . '/resources/views/quizzes/create.blade.php';
$content = file_get_contents($createFile);

$replacements = [
    "'Buat ' . (\$isPractice ? 'Latihan' : 'Quiz') . ' Baru'" => "\$isPractice ? __('Buat Latihan Baru') : __('Buat Quiz Baru')",
    "Buat {{ \$isPractice ? 'Latihan' : 'Quiz' }} Baru" => "{{ \$isPractice ? __('Buat Latihan Baru') : __('Buat Quiz Baru') }}",
    "← Kembali" => "{{ __('← Kembali') }}",
    "Judul *" => "{{ __('Judul *') }}",
    "Deskripsi</label>" => "{{ __('Deskripsi') }}</label>",
    "'-- Pilih chapter --'" => "__('-- Pilih chapter --')",
    "Maks. percobaan (kosong = tanpa batas)" => "{{ __('Maks. percobaan (kosong = tanpa batas)') }}",
    "Dibuka pada" => "{{ __('Dibuka pada') }}",
    "Ditutup pada" => "{{ __('Ditutup pada') }}",
    "Timer (menit)" => "{{ __('Timer (menit)') }}",
    "Nilai lulus *" => "{{ __('Nilai lulus *') }}",
    "Maks. percobaan *" => "{{ __('Maks. percobaan *') }}",
    "Tampilkan semua" => "{{ __('Tampilkan semua') }}",
    "Skor saja" => "{{ __('Skor saja') }}",
    "Sembunyikan detail" => "{{ __('Sembunyikan detail') }}",
    "Acak soal" => "{{ __('Acak soal') }}",
    "Acak pilihan" => "{{ __('Acak pilihan') }}",
    "Simpan & Pilih Soal" => "{{ __('Simpan & Pilih Soal') }}",
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}
file_put_contents($createFile, $content);
echo "Updated create.blade.php\n";

