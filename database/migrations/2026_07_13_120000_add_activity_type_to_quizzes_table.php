<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('activity_type', 20)->default('quiz')->after('chapter_id');
            $table->index(['course_id', 'activity_type']);
        });

        // null berarti latihan dapat dikerjakan tanpa batas.
        DB::statement('ALTER TABLE quizzes MODIFY max_attempts INT UNSIGNED NULL DEFAULT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE quizzes MODIFY max_attempts INT UNSIGNED NOT NULL DEFAULT 1');
        Schema::table('quizzes', function (Blueprint $table) {
            // Foreign key course_id membutuhkan indeks tersendiri sebelum indeks gabungan dihapus.
            $table->index('course_id');
            $table->dropIndex(['course_id', 'activity_type']);
            $table->dropColumn('activity_type');
        });
    }
};
