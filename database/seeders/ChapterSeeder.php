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
            'title' => 'BAB 1: Deskripsi Garbarata',
            'order' => 1,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 2: Data Teknis',
            'order' => 2,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 3: Instruksi Pengoperasian',
            'order' => 3,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 4: Perawatan, Inspeksi & Penyelesaian Masalah',
            'order' => 4,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 5: Daftar Suku Cadang',
            'order' => 5,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 6: Katalog Bagian Utama',
            'order' => 6,
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 7: Lampiran - Gambar Elektrik',
            'order' => 7,
        ]);
    }
}
