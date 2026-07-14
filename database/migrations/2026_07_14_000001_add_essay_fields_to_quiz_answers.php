<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->text('essay_feedback')->nullable()->after('points_earned');    // feedback instruktur
            $table->timestamp('essay_graded_at')->nullable()->after('essay_feedback'); // waktu dinilai
            $table->foreignId('essay_graded_by')->nullable()->after('essay_graded_at')
                  ->constrained('users')->nullOnDelete(); // instruktur yang menilai
        });
    }

    public function down(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropForeign(['essay_graded_by']);
            $table->dropColumn(['essay_feedback', 'essay_graded_at', 'essay_graded_by']);
        });
    }
};
