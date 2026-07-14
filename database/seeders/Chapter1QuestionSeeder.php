<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter1QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 1)->first();
        if (!$chapter) return;

        // Bersihkan data lama khusus soal chapter ini
        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        // Soal 1: Pilihan Ganda (Tipe Garbarata) -> 2 Poin
        $q1 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berdasarkan penamaan tipe Garbarata, apa arti dari kode tipe "B3 - 22/39"?',
            'type' => 'multiple_choice',
            'points' => 2,
            'explanation' => 'Kode B3 - 22/39 menunjukkan Garbarata memiliki 3 tunnel dengan panjang minimum 22 meter dan maksimum 39 meter.',
            'topic_tag' => 'Tipe Garbarata',
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Memiliki 2 tunnel dengan panjang 22 hingga 39 meter.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Memiliki 3 tunnel dengan panjang minimum 22 meter dan maksimum 39 meter.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Menggunakan 3 motor penggerak dengan kecepatan 22-39 m/s.',
            'is_correct' => false,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Lebar tunnel adalah 2.2 meter dengan tinggi 3.9 meter.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 2: Pilihan Ganda (Steering Limit Switch) -> 2 Poin
        $q2 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Di mana letak pemasangan Steering Limit Switch pada unit Wheel Boogie?',
            'type' => 'multiple_choice',
            'points' => 2,
            'explanation' => 'Steering Limit Switch dipasang pada cross beam di bawah bogie.',
            'topic_tag' => 'Wheel Boogie',
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Di atas motor listrik.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Pada shaft roda kanan.',
            'is_correct' => false,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Pada cross beam di bawah bogie.',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Di dalam control console.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 3: Pilihan Ganda (Glass Wall Panel) -> 2 Poin
        $q3 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Sistem apa yang digunakan dalam pemasangan dinding kaca (Glass Wall Panel) agar kaca tidak terbebani oleh tekanan atau beban struktur?',
            'type' => 'multiple_choice',
            'points' => 2,
            'explanation' => 'Pemasangan Glass Wall Panel menggunakan Floating System sehingga kaca tidak menerima beban struktur secara langsung.',
            'topic_tag' => 'Glass Wall Panel',
            'order' => 3
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Rigid System',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Welded System',
            'is_correct' => false,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Floating System',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Bolted System',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 4: Benar / Salah (Ramp Telescoping Tunnel) -> 1 Poin
        $q4 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Pada bagian telescoping tunnel yang bersinggungan (antara Tunnel A-B dan B-C), terdapat jembatan transisi (ramp) yang berfungsi untuk mengatasi perbedaan ketinggian lantai.',
            'type' => 'true_false',
            'points' => 1,
            'explanation' => 'Benar. Ramp berfungsi mengatasi perbedaan ketinggian lantai antar tunnel.',
            'topic_tag' => 'Telescoping Tunnel',
            'order' => 4
        ]);

        QuestionOption::create([
            'question_id' => $q4->id,
            'option_text' => 'Benar',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q4->id,
            'option_text' => 'Salah',
            'is_correct' => false,
            'order' => 1
        ]);

        // Soal 5: Benar / Salah (Pilot Lamp) -> 1 Poin
        $q5 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Lampu indikator Pilot Lamp pada Garbarata berjumlah dua buah sebagai penanda aliran tenaga listrik.',
            'type' => 'true_false',
            'points' => 1,
            'explanation' => 'Salah. Jumlah Pilot Lamp tidak hanya dua buah sebagai penanda aliran tenaga listrik.',
            'topic_tag' => 'Pilot Lamp',
            'order' => 5
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Benar',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Salah',
            'is_correct' => true,
            'order' => 1
        ]);

                // Soal 6: Benar / Salah (Ukuran Tunnel) -> 1 Poin
        $q6 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Pada unit telescoping tunnel Garbarata yang terdiri dari beberapa bagian (Tunnel A, B, dan C), ukuran tunnel yang paling besar adalah tunnel yang letaknya paling dekat dengan titik pusat Rotunda.',
            'type' => 'true_false',
            'points' => 1,
            'explanation' => 'Salah. Tunnel yang paling besar adalah Tunnel A yang terhubung dengan Rotunda, sedangkan tunnel berikutnya memiliki ukuran yang lebih kecil agar dapat masuk ke dalam tunnel sebelumnya.',
            'topic_tag' => 'Telescoping Tunnel',
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

        // Soal 7: Urutan Jawaban (Wheel Boogie) -> 1 Poin
        $q7 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan komponen penyusun Wheel Boogie berdasarkan daftar deskripsi mekanikal (urutkan 4 saja).',
            'type' => 'ordering',
            'points' => 1,
            'explanation' => 'Urutan yang benar adalah Frame → Ban (Wheels) → Drive Chain → Motor Listrik.',
            'topic_tag' => 'Wheel Boogie',
            'order' => 7
        ]);

        QuestionOption::create([
            'question_id' => $q7->id,
            'option_text' => 'Ban (Wheels)',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q7->id,
            'option_text' => 'Drive Chain',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q7->id,
            'option_text' => 'Frame',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q7->id,
            'option_text' => 'Motor Listrik',
            'is_correct' => true,
            'order' => 3
        ]);

        // Soal 8: Essay (Kabin) -> 5 Poin
        $q8 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Perhatikan deskripsi pada bagian 1.6 Kabin. Berdasarkan materi tersebut, sebutkan 3 perlengkapan/fitur yang terpasang pada area kabin untuk menunjang operasional operator!',
            'question_image' => 'images/modules/cabin.png',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Jawaban yang diharapkan adalah Side Curtain, Double Swing Door, dan Control Console.',
            'topic_tag' => 'Kabin',
            'order' => 8
        ]);

        // Soal 9: Essay (Service Access) -> 10 Poin
        $q9 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jelaskan fungsi utama dari fitur Service Access pada Garbarata dan sebutkan 3 komponen utama yang menyusun bagian tersebut!',
            'type' => 'essay',
            'points' => 10,
            'explanation' => 'Fungsi utama Service Access adalah memberikan jalur akses bagi petugas darat (ground crew) untuk berpindah dari area apron menuju ke dalam Garbarata atau sebaliknya. Komponen utamanya adalah pintu servis (service door), platform (lantai aluminium), dan tangga servis (stair).',
            'topic_tag' => 'Service Access',
            'order' => 9
        ]);

        // Soal 10: Menjodohkan (Komponen Elektrikal) -> 3 Poin
        $q10 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan komponen elektrikal berikut dengan fungsinya!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'Contractor (C) berfungsi memutuskan tenaga listrik ke komponen saat terjadi kegagalan, Terminal Blok digunakan sebagai terminal kabel, sedangkan Air Conditional Breaker merupakan pengaman arus listrik khusus sistem pendingin udara.',
            'topic_tag' => 'Komponen Elektrikal',
            'order' => 10
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Contractor (C)',
            'match_label' => 'Memutuskan tenaga listrik ke komponen saat terjadi kegagalan',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Terminal Blok (TB)',
            'match_label' => 'Digunakan sebagai terminal kabel',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'Air Conditional Breaker',
            'match_label' => 'Pengamanan arus listrik khusus untuk sistem pendingin udara',
            'is_correct' => true,
            'order' => 2
        ]);
    }
}