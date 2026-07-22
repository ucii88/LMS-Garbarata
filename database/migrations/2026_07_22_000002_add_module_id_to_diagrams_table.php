<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagrams', function (Blueprint $table) {
            $table->foreignId('chapter_id')->nullable()->change();
            $table->foreignId('module_id')->nullable()->after('chapter_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('diagrams', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropColumn('module_id');
            $table->foreignId('chapter_id')->nullable(false)->change();
        });
    }
};
