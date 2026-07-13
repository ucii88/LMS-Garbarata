<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->string('question_image')->nullable();
            $table->enum('type', [
                'multiple_choice',
                'true_false',
                'fill_blank',
                'matching',
                'ordering',
            ])->default('multiple_choice');
            $table->unsignedInteger('points')->default(1);
            $table->text('explanation')->nullable();
            $table->string('topic_tag')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
