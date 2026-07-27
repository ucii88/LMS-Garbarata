<?php

$enKeys = [
    "Kelola Pengguna" => "Manage Users",
    "Admin Panel" => "Admin Panel",
    "Tambah, edit, dan hapus akun pengguna sistem LMS Garbarata." => "Add, edit, and delete user accounts for the LMS Garbarata system.",
    "Tambah Pengguna" => "Add User",
    "Total Pengguna" => "Total Users",
    "Admin" => "Admin",
    "Instruktur" => "Instructor",
    "Peserta" => "Participant",
    "Cari nama atau email..." => "Search name or email...",
    "Semua Peran" => "All Roles",
    "Filter" => "Filter",
    "Reset" => "Reset",
    "Export Excel" => "Export to Excel",
    "Daftar Pengguna" => "User List",
    "Menampilkan" => "Showing",
    "dari" => "of",
    "pengguna" => "users",
    "Nama" => "Name",
    "Email" => "Email",
    "Peran" => "Role",
    "Terdaftar" => "Registered",
    "Aksi" => "Action",
    "Anda" => "You",
    "Detail" => "Detail",
    "Edit" => "Edit",
    "Hapus" => "Delete",
    "Tidak ada pengguna ditemukan." => "No users found.",
    "Hapus Pengguna" => "Delete User",
    "Anda akan menghapus akun" => "You are about to delete the account of",
    "Tindakan ini tidak dapat dibatalkan." => "This action cannot be undone.",
    "Ya, Hapus" => "Yes, Delete",
    "Tambah Pengguna Baru" => "Add New User",
    "Buat akun admin, instruktur, atau peserta baru." => "Create a new admin, instructor, or participant account.",
    "Nama Lengkap" => "Full Name",
    "(opsional)" => "(optional)",
    "Masukkan nama lengkap" => "Enter full name",
    "Alamat Email" => "Email Address",
    "Password" => "Password",
    "Minimal 8 karakter" => "At least 8 characters",
    "Simpan Pengguna" => "Save User",
    "Kembali ke Daftar" => "Back to List",
    "Riwayat Quiz & Ujian" => "Quiz & Exam History",
    "Daftar semua quiz dan ujian akhir yang pernah diikuti." => "List of all quizzes and final exams taken.",
    "Course / Chapter" => "Course / Chapter",
    "Tipe" => "Type",
    "Tanggal" => "Date",
    "Skor" => "Score",
    "Ujian Akhir Course" => "Course Final Exam",
    "Ujian Akhir" => "Final Exam",
    "Quiz Chapter" => "Chapter Quiz",
    "Tidak ada riwayat quiz atau ujian." => "No quiz or exam history.",
    "Sertifikat" => "Certificate",
    "Sertifikat yang berhasil diperoleh pengguna ini." => "Certificates successfully obtained by this user.",
    "Kode:" => "Code:",
    "Diterbitkan:" => "Issued:",
    "Download Sertifikat" => "Download Certificate",
    "Belum ada sertifikat." => "No certificates yet.",
    "Informasi Pengguna" => "User Information",
    "Perbarui nama, email, dan peran pengguna." => "Update user name, email, and role.",
    "Ganti Password" => "Change Password",
    "Kosongkan jika tidak ingin mengubah password." => "Leave blank if you do not want to change password.",
    "Password Baru" => "New Password",
    "Konfirmasi Password Baru" => "Confirm New Password",
    "Ulangi password baru" => "Repeat new password",
    "Kembali" => "Back",
    "Simpan Perubahan" => "Save Changes",
    "Lihat detail" => "View details",
    "Belum ada soal." => "No questions yet."
];

// Read and update en.json
$enPath = 'lang/en.json';
$enJson = json_decode(file_get_contents($enPath), true);
foreach ($enKeys as $k => $v) {
    if (!isset($enJson[$k])) {
        $enJson[$k] = $v;
    }
}
file_put_contents($enPath, json_encode($enJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Read and update id.json
$idPath = 'lang/id.json';
$idJson = json_decode(file_get_contents($idPath), true);
foreach ($enKeys as $k => $v) {
    if (!isset($idJson[$k])) {
        $idJson[$k] = $k;
    }
}
file_put_contents($idPath, json_encode($idJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Added admin panel keys to translation files successfully!\n";
