<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Langkah 1: perluas ENUM untuk menerima kedua nilai sekaligus
        DB::statement("ALTER TABLE `questions` MODIFY COLUMN `type` ENUM('multiple_choice', 'true_false', 'fill_blank', 'essay', 'matching', 'ordering') NOT NULL DEFAULT 'multiple_choice'");

        // Langkah 2: migrate data lama fill_blank → essay
        DB::statement("UPDATE `questions` SET `type` = 'essay' WHERE `type` = 'fill_blank'");

        // Langkah 3: hapus fill_blank dari ENUM (opsional, bersihkan)
        DB::statement("ALTER TABLE `questions` MODIFY COLUMN `type` ENUM('multiple_choice', 'true_false', 'essay', 'matching', 'ordering') NOT NULL DEFAULT 'multiple_choice'");
    }

    public function down(): void
    {
        // Rollback: ganti essay kembali ke fill_blank
        DB::statement("UPDATE `questions` SET `type` = 'fill_blank' WHERE `type` = 'essay'");

        DB::statement("ALTER TABLE `questions` MODIFY COLUMN `type` ENUM('multiple_choice', 'true_false', 'fill_blank', 'matching', 'ordering') NOT NULL DEFAULT 'multiple_choice'");
    }
};
