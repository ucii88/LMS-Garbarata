<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter3QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 3)->first();
        if (!$chapter) return;

        // Bersihkan data lama khusus soal chapter ini
        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        // Soal 1: Pilihan Ganda (Control Face Plate) -> 5 Poin
        $q1 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Perhatikan Gambar 3.1 (Control Face Plate). Komponen kontrol manakah yang bertipe dead man dan berfungsi menyesuaikan posisi penutup terhadap badan pesawat?',
            'question_image' => 'images/modules/control_face_plate.png',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Canopy Left and Right merupakan kontrol bertipe dead man yang digunakan untuk mengatur posisi canopy terhadap badan pesawat.',
            'topic_tag' => 'Control Face Plate',
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Vertical Drive',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Canopy Left and Right',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Adjustable Cabin',
            'is_correct' => false,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q1->id,
            'option_text' => 'Emergency Stop Push',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 2: Pilihan Ganda (Touchscreen Display) -> 5 Poin
        $q2 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berdasarkan Gambar 3.2 (Touchscreen Display), indikator nomor "viii" (MAX SWING) akan menyala dan membunyikan alarm apabila kondisi berikut terjadi...',
            'question_image' => 'images/modules/touchscreen_display.png',
            'type' => 'multiple_choice',
            'points' => 5,
            'explanation' => 'Indikator MAX SWING akan aktif apabila Rotunda telah mencapai batas maksimum rotasinya.',
            'topic_tag' => 'Touchscreen Display',
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Kabin mencapai batas putaran maksimum.',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Tunnel mencapai batas pemanjangan horizontal.',
            'is_correct' => false,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Rotunda menyentuh limit rotasinya.',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q2->id,
            'option_text' => 'Wheel Boogie mencapai limit kemudi.',
            'is_correct' => false,
            'order' => 3
        ]);

        // Soal 3: Benar / Salah (Interlock Gerakan) -> 5 Poin
        $q3 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Penggerak vertikal dapat dioperasikan secara normal meskipun unit Garbarata sedang digerakkan secara horizontal.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Salah. Gerakan vertikal hanya dapat dilakukan ketika Garbarata tidak sedang bergerak secara horizontal.',
            'topic_tag' => 'Interlock Pergerakan',
            'order' => 3
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Benar',
            'is_correct' => false,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q3->id,
            'option_text' => 'Salah',
            'is_correct' => true,
            'order' => 1
        ]);

        // Soal 4: Benar / Salah (Safety Shoe) -> 5 Poin
        $q4 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Indikator "Safety Shoe" pada layar touchscreen hanya akan menyala jika fitur tersebut aktif dalam keadaan mode "Auto".',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Benar. Indikator Safety Shoe akan aktif ketika sistem bekerja dalam mode Auto.',
            'topic_tag' => 'Touchscreen Display',
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

        // Soal 5: Mengurutkan (Mode Manual) -> 5 Poin
        $q5 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan prosedur awal untuk memulai pengoperasian dalam mode manual.',
            'type' => 'ordering',
            'points' => 5,
            'explanation' => 'Urutan yang benar adalah: Pastikan keyswitch berada dalam mode OFF → Tekan tombol Power ON hingga lampu menyala → Putar keyswitch ke mode MANUAL.',
            'topic_tag' => 'Mode Manual',
            'order' => 5
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Tekan tombol Power On hingga lampu menyala.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Putar keyswitch ke mode Manual (sampai bunyi beep).',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q5->id,
            'option_text' => 'Pastikan keyswitch berada dalam mode Off.',
            'is_correct' => true,
            'order' => 0
        ]);

                // Soal 6: Mengurutkan (Prosedur Parkir) -> 5 Poin
        $q6 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan langkah penyelesaian operasional sebelum unit ditinggalkan (Parkir).',
            'type' => 'ordering',
            'points' => 5,
            'explanation' => 'Urutan yang benar adalah: Tutup kembali pintu pesawat → Kembalikan Garbarata ke posisi parkir → Matikan seluruh daya dan putar keyswitch ke posisi OFF.',
            'topic_tag' => 'Prosedur Parkir',
            'order' => 6
        ]);

        QuestionOption::create([
            'question_id' => $q6->id,
            'option_text' => 'Matikan seluruh daya dan putar keyswitch ke keadaan Off.',
            'is_correct' => true,
            'order' => 2
        ]);

        QuestionOption::create([
            'question_id' => $q6->id,
            'option_text' => 'Tutup kembali pintu pesawat.',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q6->id,
            'option_text' => 'Kembalikan Garbarata ke posisi parkir yang ditentukan.',
            'is_correct' => true,
            'order' => 1
        ]);

        // Soal 7: Essay (CANOPY DOWN) -> 5 Poin
        $q7 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jelaskan apa yang terjadi pada sistem keamanan (interlock) pergerakan Garbarata apabila lampu indikator "CANOPY DOWN" tetap menyala pada layar touchscreen!',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Jika indikator CANOPY DOWN tetap menyala, sistem mendeteksi bahwa penutupan atau penarikan canopy belum sempurna. Kondisi ini mengaktifkan sistem interlock sehingga Garbarata tidak dapat digerakkan maju untuk mencegah benturan atau kerusakan mekanikal.',
            'topic_tag' => 'Interlock',
            'order' => 7
        ]);

        // Soal 8: Essay (Rotasi Kabin) -> 5 Poin
        $q8 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Sebutkan 4 syarat atau kondisi yang harus dipenuhi agar kabin Garbarata dapat dirotasikan ke kiri atau ke kanan!',
            'type' => 'essay',
            'points' => 5,
            'explanation' => 'Syarat rotasi kabin adalah: (1) Tombol rotasi tidak ditekan bersamaan, (2) Canopy dalam keadaan tertutup, (3) Kabin belum mencapai batas putaran maksimum kiri maupun kanan, dan (4) Kabin tidak menyentuh badan pesawat.',
            'topic_tag' => 'Rotasi Kabin',
            'order' => 8
        ]);

        // Soal 9: Menjodohkan (Posisi Keyswitch) -> 5 Poin
        $q9 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan posisi Keyswitch berikut dengan status operasional Garbarata yang sesuai!',
            'type' => 'matching',
            'points' => 5,
            'explanation' => 'OFF membuat seluruh pergerakan manual terkunci, MANUAL mengaktifkan seluruh komponen secara manual, sedangkan AUTO menempatkan Garbarata pada kondisi standby.',
            'topic_tag' => 'Keyswitch',
            'order' => 9
        ]);

        QuestionOption::create([
            'question_id' => $q9->id,
            'option_text' => 'OFF',
            'match_label' => 'Seluruh pergerakan manual akan mati/terkunci.',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q9->id,
            'option_text' => 'MANUAL',
            'match_label' => 'Seluruh komponen penggerak dapat digerakkan manual.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q9->id,
            'option_text' => 'AUTO',
            'match_label' => 'Garbarata dalam keadaan stand by.',
            'is_correct' => true,
            'order' => 2
        ]);

        // Soal 10: Menjodohkan (Touchscreen Indicator) -> 5 Poin
        $q10 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan jenis indikator pada touchscreen dengan kondisi pemicu aktifnya!',
            'type' => 'matching',
            'points' => 5,
            'explanation' => 'MAX TRAVEL aktif saat tunnel mencapai batas pemanjangan/pemendekan maksimum, SERVICE WARNING muncul ketika terdapat error atau alarm sistem, dan COLUMN FAULT muncul saat lift column kiri dan kanan tidak sejajar.',
            'topic_tag' => 'Touchscreen Indicator',
            'order' => 10
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'MAX TRAVEL',
            'match_label' => 'Tunnel mencapai pemanjangan/pemendekan maksimum.',
            'is_correct' => true,
            'order' => 0
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'SERVICE WARNING',
            'match_label' => 'Ada error atau alarm pada sistem Garbarata.',
            'is_correct' => true,
            'order' => 1
        ]);

        QuestionOption::create([
            'question_id' => $q10->id,
            'option_text' => 'COLUMN FAULT',
            'match_label' => 'Lift column kiri dan kanan tidak seimbang/sejajar.',
            'is_correct' => true,
            'order' => 2
        ]);
    }
}