<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter2QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 2)->first();
        if (!$chapter) return;

        // Bersihkan data lama khusus soal chapter ini
        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        // Soal 1: Pilihan Ganda (Main Distribution Panel) -> 5 Poin
        $q1 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Di mana letak posisi Main-Distribution Panel pada unit Garbarata?',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Main-Distribution Panel terletak pada Rotunda Column sebagai pusat distribusi tenaga listrik Garbarata.',
            'topic_tag' => 'Main Distribution Panel',
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Di dalam kabin operator.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Pada Rotunda Column.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Di atas atap Telescopic Tunnel.',
            'is_correct' => false,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Di bawah Wheel Boogie.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 2: Pilihan Ganda (Drive Power) -> 5 Poin
        $q2 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berapa spesifikasi tenaga listrik (Drive Power) yang dibutuhkan untuk menggerakkan motor Garbarata?',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Motor penggerak Garbarata menggunakan tenaga listrik 380V 3-phase 50 Hz.',
            'topic_tag' => 'Drive Power',
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => '220V single phase 50 Hz.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => '220V 3-phase 60 Hz.',
            'is_correct' => false,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => '380V 3-phase 50 Hz.',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => '380V single phase 50 Hz.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 3: Pilihan Ganda (Tipe B2 - 21/28) -> 5 Poin
        $q3 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berdasarkan penamaan tipe B2 - 21/28, apa arti dari angka "21/28"?',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Angka 21/28 menunjukkan panjang minimum Garbarata 21 meter dan panjang maksimum 28 meter.',
            'topic_tag' => 'Tipe Garbarata',
            'order' => 3
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Lebar 21 meter dan tinggi 28 meter.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Panjang minimum 21 meter dan panjang maksimum 28 meter.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Kecepatan gerak 21 m/min hingga 28 m/min.',
            'is_correct' => false,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Kapasitas penumpang 21 hingga 28 orang.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 4: Benar / Salah (Kecepatan Angin) -> 5 Poin
        $q4 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Batas kecepatan angin maksimum saat Garbarata tidak beroperasi adalah 27 m/s.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Salah. Batas kecepatan angin saat Garbarata tidak beroperasi adalah 40 m/s, sedangkan 27 m/s merupakan batas saat Garbarata sedang dioperasikan.',
            'topic_tag' => 'Wind Speed',
            'order' => 4
        ]);

        QuestionOption::create([
            'question_id' => $q4->id,
            'option_text' => 'Benar',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q4->id,
            'option_text' => 'Salah',
            'is_correct' => true,
            'order' => 1
        ]);

        // Soal 5: Benar / Salah (Rotasi Kabin) -> 5 Poin
        $q5 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Sudut rotasi kabin maksimum, baik ke arah kiri maupun kanan, adalah sebesar 75°.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Benar. Sudut rotasi maksimum kabin ke arah kiri maupun kanan adalah 75°.',
            'topic_tag' => 'Cabin Rotation',
            'order' => 5
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Benar',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Salah',
            'is_correct' => false,
            'order' => 1
        ]);

                // Soal 6: Benar / Salah (Minimum Clear Internal Height) -> 5 Poin
        $q6 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jarak internal bersih terendah (Minimum Clear Internal Height) di dalam tunnel adalah 1.49 meter.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Salah. Nilai 1.49 meter merupakan Minimum Clear Internal Width (lebar), sedangkan Minimum Clear Internal Height adalah 2.15 meter.',
            'topic_tag' => 'Dimensi Tunnel',
            'order' => 6
        ]);

        QuestionOption::create([
            'question_id' => $q6->id,
            'option_text' => 'Benar',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q6->id,
            'option_text' => 'Salah',
            'is_correct' => true,
            'order' => 1
        ]);

        // Soal 7: Essay (Dimensi Tunnel) -> 5 Poin
        $q7 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jelaskan apa yang dimaksud dengan dimensi Minimum Clear Internal Height dan Minimum Clear Internal Width pada lorong tunnel Garbarata, serta sebutkan masing-masing nilainya!',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Jawaban yang diharapkan: Minimum Clear Internal Height adalah ruang bebas hambatan minimum pada tinggi lorong sebesar 2.15 meter, sedangkan Minimum Clear Internal Width adalah ruang bebas hambatan minimum pada lebar lorong sebesar 1.49 meter.',
            'topic_tag' => 'Dimensi Tunnel',
            'order' => 7
        ]);

        // Soal 8: Essay (Limit Switch Safety Hoop) -> 5 Poin
        $q8 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Uraikan fungsi dari komponen Limit Switch Safety Hoop yang terpasang pada unit Wheel Boogie!',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Limit Switch Safety Hoop berfungsi sebagai pelindung sekaligus pendeteksi benda asing pada area roda (Wheel Boogie). Apabila terjadi kontak dengan benda asing, sensor akan aktif sehingga memberikan peringatan atau menghentikan gerakan untuk mencegah kerusakan.',
            'topic_tag' => 'Wheel Boogie',
            'order' => 8
        ]);

        // Soal 9: Essay (Drive Power) -> 5 Poin
        $q9 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Sebutkan spesifikasi tenaga listrik (Drive Power) yang diperlukan untuk mengoperasikan sistem penggerak Garbarata ini!',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Jawaban yang diharapkan: Sistem menggunakan tenaga 380V 3-phase 50 Hz untuk motor penggerak utama, sedangkan rangkaian kontrol menggunakan 220VAC dan 24VDC dari switching power supply.',
            'topic_tag' => 'Drive Power',
            'order' => 9
        ]);

        // Soal 10: Menjodohkan (Kecepatan Operasional) -> 3 Poin
        $q10 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan jenis pergerakan operasional berikut dengan kecepatan standarnya!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'Gerakan Horizontal memiliki kecepatan 0–25 meter/menit, Gerakan Vertikal memiliki kecepatan 0.78 meter/menit, dan Rotasi Kabin memiliki kecepatan kurang dari 2°/detik.',
            'topic_tag' => 'Kecepatan Operasional',
            'order' => 10
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Gerakan Horizontal',
            'match_label' => '0 - 25 meter / menit',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Gerakan Vertikal',
            'match_label' => '0.78 meter / menit',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Rotasi Kabin',
            'match_label' => '< 2° / detik',
            'is_correct' => true,
            'order' => 2
        ]);

                // Soal 11: Essay (Dimensi Internal) -> 5 Poin
        $q11 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Perhatikan gambar pada bagian 1.3.1 Dimensi Internal. Apakah yang dimaksud dengan label (A) dan berapakah nilainya?',
            'question_image' => 'images/modules/dimensi_internal.png',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Label (A) menunjukkan Minimum Clear Internal Width (lebar internal bersih minimum) dengan nilai 1.49 meter.',
            'topic_tag' => 'Dimensi Internal',
            'order' => 11
        ]);

        // Soal 12: Essay (Sudut Putar Horizontal Rotunda) -> 5 Poin
        $q12 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Lihat gambar Sudut Putar Horizontal Rotunda. Berapakah derajat putaran maksimum untuk arah kiri (A) dan kanan (B)?',
            'question_image' => 'images/modules/sudut_putar_horizontal_rotunda.png',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Sudut putar maksimum untuk arah kiri maupun kanan adalah 87.5°.',
            'topic_tag' => 'Sudut Putar Horizontal Rotunda',
            'order' => 12
        ]);
    }
}

