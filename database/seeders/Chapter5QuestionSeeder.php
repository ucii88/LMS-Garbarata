<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter5QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 5)->first();
        if (!$chapter) return;

        // Bersihkan data lama khusus soal chapter ini
        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        // Soal 1: Pilihan Ganda (Part number Potentiometer) -> 10 Poin
        $q1 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Berdasarkan daftar suku cadang Rotunda Assembly, apakah nama komponen yang memiliki kode part number "ORT023SM"?',
            'type' => 'multiple_choice',
            'points' => 10,
            'explanation' => 'Part number ORT023SM merujuk pada Potentiometer Rotunda Assy.',
            'topic_tag' => 'Rotunda Parts',
            'order' => 1
        ]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Potentiometer Rotunda Assy', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Guide Pipe Barrel', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Roller Bearing Rotunda', 'is_correct' => false, 'order' => 2]);
        QuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Worm Gear Assembly', 'is_correct' => false, 'order' => 3]);

        // Soal 2: Benar / Salah (Curtain Barrel) -> 5 Poin
        $q2 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Part number "ORT001AM" and "ORT002AM" berturut-turut merupakan suku cadang untuk rakitan curtain barrel (penutup celah) sisi kiri dan sisi kanan pada Rotunda.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Benar. ORT001AM adalah sisi kiri (Left side) dan ORT002AM adalah sisi kanan (Right side).',
            'topic_tag' => 'Rotunda Parts',
            'order' => 2
        ]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Benar', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Salah', 'is_correct' => false, 'order' => 1]);

        // Soal 3: Esai (Pentingnya Part Number) -> 15 Poin
        $q3 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Mengapa ketelitian dalam menuliskan part number (seperti ORT107AM untuk Carpet) sangat krusial saat melakukan pemesanan suku cadang Garbarata kepada pihak manufaktur?',
            'type' => 'essay',
            'points' => 15,
            'explanation' => 'Ketelitian part number penting untuk mencegah ketidakcocokan dimensi, tipe bearing, atau spesifikasi mekanik/elektrik saat komponen pengganti dipasang. Kesalahan kode dapat menyebabkan keterlambatan operasional Garbarata.',
            'topic_tag' => 'Manajemen Suku Cadang',
            'order' => 3
        ]);

        // Soal 4: Menjodohkan (Kode Suku Cadang) -> 9 Poin (3 pasang @ 3 Poin)
        $q4 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan nama suku cadang berikut dengan kode part number resminya yang benar!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'ORT107AM untuk carpet, ORT008AM untuk roller bearing, ORT103AM untuk guide pipe barrel.',
            'topic_tag' => 'Identifikasi Part',
            'order' => 4
        ]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Carpet for Rotunda', 'match_label' => 'ORT107AM', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Roller Bearing Rotunda', 'match_label' => 'ORT008AM', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q4->id, 'option_text' => 'Guide Pipe Barrel', 'match_label' => 'ORT103AM', 'is_correct' => true, 'order' => 2]);

        // Soal 5: Urutan Langkah (Urutan No Item Drawing) -> 12 Poin (4 langkah @ 3 Poin)
        $q5 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan komponen Rotunda Assembly berikut berdasarkan nomor item terkecil hingga terbesar pada gambar Technical Drawing!',
            'type' => 'ordering',
            'points' => 3,
            'explanation' => 'Urutan No. Item: 1 (Left Barrel), 3 (Guide Pipe), 4 (Tension Barrel Bearing), 6 (Tension Barrel).',
            'topic_tag' => 'Technical Drawing',
            'order' => 5
        ]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Barrel Rotunda Curtain Assembly Left (No. 1)', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Guide Pipe Barrel (No. 3)', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Tension Barrel Bearing (No. 4)', 'is_correct' => true, 'order' => 2]);
        QuestionOption::create(['question_id' => $q5->id, 'option_text' => 'Tension Barrel (No. 6)', 'is_correct' => true, 'order' => 3]);

        // Soal 6: Pilihan Ganda (Worm Gear Assembly) -> 10 Poin
        $q6 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Manakah kode part number resmi yang sesuai untuk komponen Worm Gear Assembly (L/R) pada Rotunda?',
            'type' => 'multiple_choice',
            'points' => 10,
            'explanation' => 'Berdasarkan tabel daftar komponen, Worm Gear Assembly memiliki part number ORT013AM.',
            'topic_tag' => 'Rotunda Parts',
            'order' => 6
        ]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'ORT013AM', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'ORT012CM', 'is_correct' => false, 'order' => 1]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'ORT013CM', 'is_correct' => false, 'order' => 2]);
        QuestionOption::create(['question_id' => $q6->id, 'option_text' => 'ORT106AM', 'is_correct' => false, 'order' => 3]);

        // Soal 7: Benar / Salah (Carpet Part Number) -> 5 Poin
        $q7 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Part number "ORT107AM" merupakan kode komponen resmi untuk Carpet for Rotunda.',
            'type' => 'true_false',
            'points' => 5,
            'explanation' => 'Benar. Suku cadang Carpet for Rotunda terdaftar dengan kode ORT107AM.',
            'topic_tag' => 'Rotunda Parts',
            'order' => 7
        ]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Benar', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q7->id, 'option_text' => 'Salah', 'is_correct' => false, 'order' => 1]);

        // Soal 8: Esai (Deskripsi Suku Cadang Rotunda) -> 15 Poin
        $q8 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Sebutkan minimal 3 nama suku cadang yang digunakan pada perakitan Rotunda Assembly beserta kode part numbernya berdasarkan materi Bab 5!',
            'type' => 'essay',
            'points' => 15,
            'explanation' => 'Contoh suku cadang: 1. Carpet for Rotunda (ORT107AM), 2. Tension Barrel (ORT104AM), 3. Hinge Pin (ORT012CM).',
            'topic_tag' => 'Rotunda Parts',
            'order' => 8
        ]);

        // Soal 9: Menjodohkan (Kode & Komponen Tambahan) -> 9 Poin (3 pasang @ 3 Poin)
        $q9 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Jodohkan nama komponen berikut dengan kode part numbernya yang benar!',
            'type' => 'matching',
            'points' => 3,
            'explanation' => 'Guide Pipe Barrel adalah ORT103AM, Hinge Pin adalah ORT012CM, Plate Curtain Upper adalah ORT106AM.',
            'topic_tag' => 'Rotunda Parts',
            'order' => 9
        ]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Guide Pipe Barrel', 'match_label' => 'ORT103AM', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Hinge Pin', 'match_label' => 'ORT012CM', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q9->id, 'option_text' => 'Plate Curtain Upper', 'match_label' => 'ORT106AM', 'is_correct' => true, 'order' => 2]);

        // Soal 10: Urutan Langkah (Urutan Komponen dari Atas ke Bawah) -> 9 Poin (3 langkah @ 3 Poin)
        $q10 = Question::create([
            'course_id' => $chapter->course_id,
            'chapter_id' => $chapter->id,
            'question_text' => 'Urutkan komponen-komponen berikut dari posisi teratas hingga posisi terbawah (lantai) pada perakitan curtain Rotunda!',
            'type' => 'ordering',
            'points' => 3,
            'explanation' => 'Urutan dari atas ke bawah: Plate Curtain Upper (atas), Slat Curtain Assy (tengah/selubung), Carpet for Rotunda (bawah/lantai).',
            'topic_tag' => 'SOP Perakitan',
            'order' => 10
        ]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Plate Curtain Upper (Bagian Atas)', 'is_correct' => true, 'order' => 0]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Slat Curtain Assy (Sisi Selubung Tengah)', 'is_correct' => true, 'order' => 1]);
        QuestionOption::create(['question_id' => $q10->id, 'option_text' => 'Carpet for Rotunda (Bagian Alas/Lantai)', 'is_correct' => true, 'order' => 2]);
    }
}
