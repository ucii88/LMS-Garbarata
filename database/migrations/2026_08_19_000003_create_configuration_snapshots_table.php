<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuration_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->foreignId('config_id')->constrained('certificate_configurations')->restrictOnDelete()->comment('Source configuration record');
            $table->enum('template_preset', ['current_style', 'elegant_classic_1', 'elegant_classic_2']);
            $table->foreignId('instructor_id')->nullable()->constrained('users')->restrictOnDelete()->comment('Assigned instructor at snapshot time');
            $table->string('instructor_signature_path', 500)->nullable()->comment('Signature file path at snapshot time');
            $table->string('kepala_signature_path', 500)->nullable()->comment('Kepala signature file path');
            $table->string('organization_name', 200);
            $table->string('logo_path', 500)->nullable();
            $table->string('primary_color', 7);
            $table->string('secondary_color', 7);
            $table->unsignedInteger('version')->default(1)->comment('Snapshot version number');
            $table->timestamp('created_at')->useCurrent()->comment('Immutable timestamp');
            $table->foreignId('created_by_admin_id')->constrained('users')->restrictOnDelete();

            $table->index(['course_id', 'created_at'], 'snapshots_course_created_idx');
            $table->index('config_id', 'snapshots_config_idx');
            $table->index('created_at', 'snapshots_created_at_idx');
            $table->unique(['course_id', 'version'], 'snapshots_course_version_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuration_snapshots');
    }
};
