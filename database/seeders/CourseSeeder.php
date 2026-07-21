<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate to ensure clean state (removes any test records)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Course::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Course::create([
            'title' => [
                'id' => 'Pengenalan dan Pengoperasian Garbarata',
                'en' => 'Introduction and Operation of Passenger Boarding Bridge (Garbarata)',
            ],
            'description' => [
                'id' => 'Mata kuliah/training dasar mengenai komponen mekanik, sistem elektrik, keselamatan kerja, dan standar operasional prosedur (SOP) pengoperasian Garbarata (Passenger Boarding Bridge) di bandar udara.',
                'en' => 'Basic training course on mechanical components, electrical systems, safety, and standard operating procedures (SOP) for operating Passenger Boarding Bridge (Garbarata) at airports.',
            ],
            'thumbnail' => 'course_garbarata.jpg',
            'is_published' => true,
        ]);
    }
}
