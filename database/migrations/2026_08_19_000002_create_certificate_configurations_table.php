<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->unique()->constrained()->cascadeOnDelete()->comment('One config per course');
            $table->enum('template_preset', ['current_style', 'elegant_classic_1', 'elegant_classic_2'])->default('current_style');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->nullOnDelete()->comment('Assigned instructor for signatures');
            $table->foreignId('kepala_training_signature_id')->nullable()->constrained('signatures')->nullOnDelete()->comment('Custom kepala signature');
            $table->string('organization_name', 200)->default('Garbarata Training Center');
            $table->string('logo_path', 500)->nullable()->comment('Custom logo for this course');
            $table->string('primary_color', 7)->default('#d97706')->comment('Hex color');
            $table->string('secondary_color', 7)->default('#b45309')->comment('Hex color');
            $table->foreignId('updated_by_admin_id')->nullable()->constrained('users')->nullOnDelete()->comment('Admin who made last change');
            $table->timestamps();

            $table->index('instructor_id', 'cert_configs_instructor_idx');
            $table->index('updated_at', 'cert_configs_updated_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_configurations');
    }
};
