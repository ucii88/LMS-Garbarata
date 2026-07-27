<?php

$enFile = __DIR__ . '/lang/en.json';
$idFile = __DIR__ . '/lang/id.json';

$en = json_decode(file_get_contents($enFile), true) ?? [];
$id = json_decode(file_get_contents($idFile), true) ?? [];

$idTranslations = [
    'User_Data_' => 'Data_Pengguna_',
    'Full Name' => 'Nama Lengkap',
    'Registration Date' => 'Tanggal Daftar',
    'Quiz Score' => 'Nilai Quiz',
    'Exam Score' => 'Nilai Ujian',
    'Certificate Link' => 'Link Sertifikat',
    'Data pengguna :email berhasil diperbarui.' => 'Data pengguna :email berhasil diperbarui.',
    'Gagal menambahkan akun :email, sebagai :role.' => 'Gagal menambahkan akun :email, sebagai :role.',
    'Berhasil menambahkan akun :email, sebagai :role.' => 'Berhasil menambahkan akun :email, sebagai :role.',
    'Anda tidak dapat menghapus akun Anda sendiri.' => 'Anda tidak dapat menghapus akun Anda sendiri.',
    'Pengguna berhasil dihapus.' => 'Pengguna berhasil dihapus.',
];

$enTranslations = [
    'User_Data_' => 'User_Data_',
    'Full Name' => 'Full Name',
    'Registration Date' => 'Registration Date',
    'Quiz Score' => 'Quiz Score',
    'Exam Score' => 'Exam Score',
    'Certificate Link' => 'Certificate Link',
    'Data pengguna :email berhasil diperbarui.' => 'User data :email successfully updated.',
    'Gagal menambahkan akun :email, sebagai :role.' => 'Failed to add account :email, as :role.',
    'Berhasil menambahkan akun :email, sebagai :role.' => 'Successfully added account :email, as :role.',
    'Anda tidak dapat menghapus akun Anda sendiri.' => 'You cannot delete your own account.',
    'Pengguna berhasil dihapus.' => 'User successfully deleted.',
];

foreach ($idTranslations as $key => $val) {
    if (!isset($id[$key])) {
        $id[$key] = $val;
    }
}

foreach ($enTranslations as $key => $val) {
    if (!isset($en[$key])) {
        $en[$key] = $val;
    }
}

file_put_contents($idFile, json_encode($id, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents($enFile, json_encode($en, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Added controller translations successfully.\n";
