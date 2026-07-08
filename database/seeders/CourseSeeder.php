<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'title' => 'Pengenalan dan Pengoperasian Garbarata',
            'description' => 'Mata kuliah/training dasar mengenai komponen mekanik, sistem elektrik, keselamatan kerja, dan standar operasional prosedur (SOP) pengoperasian Garbarata (Passenger Boarding Bridge) di bandar udara.',
            'thumbnail' => 'course_garbarata.jpg',
            'is_published' => true,
        ]);
    }
}
