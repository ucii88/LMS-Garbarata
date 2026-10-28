<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('file_path', 500)->comment('Storage path to signature image');
            $table->string('file_name', 255)->comment('Original filename');
            $table->enum('signature_type', ['instructor', 'kepala_training']);
            $table->timestamps();

            $table->index(['user_id', 'signature_type'], 'signatures_user_type_idx');
            $table->index('created_at', 'signatures_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
