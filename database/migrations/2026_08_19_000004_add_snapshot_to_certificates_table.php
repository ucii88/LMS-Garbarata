<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Add snapshot_id after course_id
            $table->foreignId('snapshot_id')->nullable()->after('course_id')->constrained('configuration_snapshots')->restrictOnDelete();
            
            // Add pdf_path after certificate_code
            $table->string('pdf_path', 500)->nullable()->after('certificate_code');

            // Add indexes
            $table->index('snapshot_id', 'idx_snapshot_id');
            $table->index('issued_at', 'idx_issued_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex('idx_snapshot_id');
            $table->dropIndex('idx_issued_at');
            
            // Drop foreign key and column
            $table->dropForeign(['snapshot_id']);
            $table->dropColumn(['snapshot_id', 'pdf_path']);
        });
    }
};
