<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();

        if (!$course) {
            return;
        }

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 1: Deskripsi Garbarata',
                'en' => 'CHAPTER 1: Passenger Boarding Bridge Description',
            ],
            'order' => 1,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 2: Data Teknis',
                'en' => 'CHAPTER 2: Technical Data',
            ],
            'order' => 2,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 3: Instruksi Pengoperasian',
                'en' => 'CHAPTER 3: Operating Instructions',
            ],
            'order' => 3,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 4: Perawatan, Inspeksi & Penyelesaian Masalah',
                'en' => 'CHAPTER 4: Maintenance, Inspection & Troubleshooting',
            ],
            'order' => 4,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 5: Daftar Suku Cadang',
                'en' => 'CHAPTER 5: Spare Parts List',
            ],
            'order' => 5,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 6: Katalog Bagian Utama',
                'en' => 'CHAPTER 6: Main Parts Catalog',
            ],
            'order' => 6,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => [
                'id' => 'BAB 7: Lampiran - Gambar Elektrik',
                'en' => 'CHAPTER 7: Appendix - Electrical Drawings',
            ],
            'order' => 7,
        ]);
    }
}
