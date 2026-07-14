<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter4QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 4)->first();
        if (!$chapter) return;

        // Bersihkan data lama khusus soal chapter ini
        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        // Soal 1: Pilihan Ganda (Bahan pembersih karpet & jendela) -> 5 Poin
        $q1 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Bahan pembersih apakah yang dianjurkan untuk membersihkan karpet dan jendela Garbarata guna mencegah kerusakan material?',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Pembersihan karpet dan jendela harus menggunakan shampoo yang bebas detergen berkualitas tinggi.',
            'topic_tag' => 'Pembersihan Rutin',
            'order' => 1
        ]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Shampoo bebas detergen', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Detergen konsentrat tinggi', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Cairan pemutih klorin', 'is_correct' => false, 'order' => 2]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Sabun cuci piring pekat', 'is_correct' => false, 'order' => 3]);

        // Soal 2: Benar / Salah (Pengecatan bagian bergerak) -> 5 Poin
        $q2 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Untuk mencegah karat, bagian-bagian bergerak seperti rantai, sprocket, bearing, dan roller pada Garbarata harus dilapisi cat dasar logam dan polyurethane secara berkala.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Salah. Bagian bergerak seperti rantai, sprocket, shaft, bearing, roller, atau rel TIDAK boleh dicat.',
            'topic_tag' => 'Pengecatan Ulang',
            'order' => 2
        ]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Benar', 'is_correct' => false, 'order' => 0]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Salah', 'is_correct' => true, 'order' => 1]);

        // Soal 3: Esai (Pertimbangan Umum Maintenance) -> 15 Poin
        $q3 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jelaskan mengapa pemeliharaan/inspeksi berkala pada permukaan luar Garbarata yang bercat sangat penting, serta apa akibatnya jika tumpahan minyak hidrokarbon dibiarkan terlalu lama!',
            'type' => 'essay',
            'points' => 15,
            'explanation' => 'Inspeksi berkala penting untuk mencegah reaksi kotoran dan sisa pelumas dengan cat. Minyak hidrokarbon yang dibiarkan dapat merusak lapisan cat pelindung, memicu korosi dini pada struktur logam Garbarata.',
            'topic_tag' => 'Preventive Maintenance',
            'order' => 3
        ]);

        // Soal 4: Menjodohkan (Interval Perawatan) -> 9 Poin (3 pasang @ 3 Poin)
        $q4 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan aktivitas perawatan berikut dengan interval waktu pelaksanaannya yang tepat berdasarkan manual Garbarata!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'Pembersihan karpet & jendela dilakukan harian. Perawatan keseluruhan dilakukan 3 bulanan. Pembersihan minyak hidrokarbon dilakukan 6 bulanan.',
            'topic_tag' => 'Interval Perawatan',
            'order' => 4
        ]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Pembersihan karpet dan jendela', 'match_label' => 'Setiap hari (Harian)', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Perawatan rutin keseluruhan (triwulan)', 'match_label' => 'Tiga bulan sekali', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Pembersihan endapan minyak hidrokarbon', 'match_label' => 'Setengah tahun sekali (6 bulan)', 'is_correct' => true, 'order' => 2]);

        // Soal 5: Urutan Langkah (Prosedur Pengecatan Karat) -> 12 Poin (4 langkah @ 3 Poin)
        $q5 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan langkah-langkah pengecatan ulang permukaan luar Garbarata yang berkarat atau mengelupas dengan benar!',
            'type' => 'ordering',
            'points' => 3,
            'explanation' => 'Urutan yang benar: 1. Gunakan pelarut untuk membersihkan kotoran/minyak, 2. Gunakan amplas untuk membersihkan karat, 3. Beri cat dasar berkualitas tinggi, 4. Lapisi dengan dua lapis polyurethane enamel.',
            'topic_tag' => 'Prosedur Cat Ulang',
            'order' => 5
        ]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Gunakan pelarut untuk membersihkan daerah kotor/berminyak', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Gunakan amplas halus untuk membersihkan karat dan cat mengelupas', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Aplikasikan cat dasar berkualitas tinggi untuk logam', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Akhiri dengan dua lapis polyurethane enamel sesuai warna', 'is_correct' => true, 'order' => 3]);

        // Soal 6: Pilihan Ganda (Bantalan Lift Column) -> 5 Poin
        $q6 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berapakah ketebalan minimum dari bantalan lift column (column guides) sebelum diwajibkan untuk diganti dengan pad yang baru?',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Berdasarkan tabel ketebalan bantalan, jika ketebalan mencapai 22 mm, pad harus segera diganti.',
            'topic_tag' => 'Bantalan Lift Column',
            'order' => 6
        ]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => '22 mm', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => '25 mm', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => '23.5 mm', 'is_correct' => false, 'order' => 2]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => '20 mm', 'is_correct' => false, 'order' => 3]);

        // Soal 7: Benar / Salah (Bantalan Lift Column Guides) -> 5 Poin
        $q7 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Setiap lift column pada Garbarata memiliki 8 bantalan (4 di bagian atas dan 4 di bagian bawah) untuk mencegah terjadinya gesekan langsung antarlogam.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Benar. Setiap lift column memiliki 8 bantalan, 4 di atas dan 4 di bawah.',
            'topic_tag' => 'Bantalan Lift Column',
            'order' => 7
        ]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Benar', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Salah', 'is_correct' => false, 'order' => 1]);

        // Soal 8: Esai (Penyelesaian Masalah Column Fault) -> 15 Poin
        $q8 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jelaskan apa yang dimaksud dengan Column Fault pada Vertical Lift Column, serta sebutkan indikasi yang memicu sistem proteksi ini menyala!',
            'type' => 'essay',
            'points' => 15,
            'explanation' => 'Column Fault terjadi jika salah satu lift column bergerak lebih cepat dari yang lain sehingga miring/condong. Indikator menyala bila salah satu column naik 70mm lebih tinggi dari yang lain.',
            'topic_tag' => 'Troubleshooting',
            'order' => 8
        ]);

        // Soal 9: Menjodohkan (Trouble & Gejala) -> 9 Poin (3 pasang @ 3 Poin)
        $q9 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan kode Trouble berikut dengan gejala kerusakan yang ditimbulkannya pada sistem Garbarata!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'Trouble 11 adalah motor horizontal berdengung tapi tidak jalan. Trouble 12 adalah Canopy Closure tidak mau naik/turun. Trouble 15 adalah tiang miring/condong.',
            'topic_tag' => 'Troubleshooting',
            'order' => 9
        ]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Trouble 11', 'match_label' => 'Motor horizontal berdengung, tapi tidak beroperasi', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Trouble 12', 'match_label' => 'Canopy Closure tidak mau naik atau turun', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Trouble 15', 'match_label' => 'Tiang Vertical Lift Column miring/tidak sejajar', 'is_correct' => true, 'order' => 2]);

        // Soal 10: Urutan Langkah (Prosedur Pelepasan Ban) -> 20 Poin (4 langkah @ 5 Poin)
        $q10 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan langkah pertama hingga akhir dalam prosedur pelepasan ban Garbarata untuk pemeliharaan roda!',
            'type' => 'ordering',
            'points' => 5,
            'explanation' => 'Langkah pelepasan ban: 1. Naikkan di atas dongkrak, 2. Tahan tombol down sampai roda menyentuh tanah, 3. Bongkar pelindung dan putus rantai, 4. Lepaskan bearing tapper lockwasher.',
            'topic_tag' => 'Pemeliharaan Ban',
            'order' => 10
        ]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Angkat Garbarata di atas dongkrak / Jacking Stand', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Tahan tombol down hingga roda menyentuh tanah', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Bongkar pelindung rantai dan putus rantai', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Lepaskan bearing tapper yang terpasang pada lockwasher', 'is_correct' => true, 'order' => 3]);
    }
}
