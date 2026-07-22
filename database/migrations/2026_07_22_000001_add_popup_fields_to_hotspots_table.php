<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->foreignId('target_module_id')->nullable()->change();
            $table->string('action_type')->default('navigate')->after('diagram_id'); // 'navigate' or 'popup'
            $table->string('popup_title')->nullable()->after('label');
            $table->text('popup_content')->nullable()->after('popup_title');
            $table->string('popup_image')->nullable()->after('popup_content');
        });
    }

    public function down(): void
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->foreignId('target_module_id')->nullable(false)->change();
            $table->dropColumn(['action_type', 'popup_title', 'popup_content', 'popup_image']);
        });
    }
};
