<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // auto   = tidak ada soal esai, nilai langsung final
            // pending_essay = ada soal esai yang belum dinilai instruktur
            // graded = semua soal esai sudah dinilai, nilai final
            $table->enum('grading_status', ['auto', 'pending_essay', 'graded'])
                  ->default('auto')
                  ->after('is_passed');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropColumn('grading_status');
        });
    }
};
