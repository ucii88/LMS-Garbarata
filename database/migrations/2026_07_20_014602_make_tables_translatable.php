<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear existing data first to avoid json constraint violation on existing non-JSON strings
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('question_options')->truncate();
        DB::table('questions')->truncate();
        DB::table('modules')->truncate();
        DB::table('chapters')->truncate();
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::table('courses', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('description')->nullable()->change();
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->json('title')->change();
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('content')->nullable()->change();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->json('question_text')->change();
        });

        Schema::table('question_options', function (Blueprint $table) {
            $table->json('option_text')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->string('title')->change();
            $table->longText('content')->nullable()->change();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->text('question_text')->change();
        });

        Schema::table('question_options', function (Blueprint $table) {
            $table->text('option_text')->change();
        });
    }
};
