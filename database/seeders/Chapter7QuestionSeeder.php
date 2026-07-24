<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter7QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 7)->first();
        if (!$chapter) return;

        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        $items = [
            [
                'question_text' => ['id' => 'Apa fungsi utama lampiran gambar elektrikal pada Chapter 7 dalam pekerjaan pemeliharaan Garbarata?', 'en' => 'What is the main function of the electrical drawing appendices in Chapter 7 for Garbarata maintenance work?'],
                'type' => 'multiple_choice',
                'points' => 5,
                'explanation' => ['id' => 'Lampiran gambar elektrikal digunakan sebagai acuan untuk membaca hubungan rangkaian, jalur kabel, terminal, dan komponen saat inspeksi atau troubleshooting.', 'en' => 'The electrical drawing appendices are used as references for reading circuit relationships, wiring routes, terminals, and components during inspection or troubleshooting.'],
                'topic_tag' => 'Gambar Elektrikal',
                'options' => [
                    [['id' => 'Sebagai acuan membaca rangkaian dan jalur kabel', 'en' => 'As a reference for reading circuits and wiring routes'], true],
                    [['id' => 'Sebagai daftar hadir teknisi', 'en' => 'As a technician attendance list'], false],
                    [['id' => 'Sebagai jadwal penerbangan harian', 'en' => 'As a daily flight schedule'], false],
                    [['id' => 'Sebagai panduan dekorasi kabin', 'en' => 'As a cabin decoration guide'], false],
                ],
            ],
            [
                'question_text' => ['id' => 'Gambar as-built elektrikal harus digunakan untuk membantu teknisi menelusuri kondisi aktual instalasi kabel dan komponen di lapangan.', 'en' => 'Electrical as-built drawings should be used to help technicians trace the actual installed condition of wiring and components in the field.'],
                'type' => 'true_false',
                'points' => 5,
                'explanation' => ['id' => 'Benar. Gambar as-built menunjukkan kondisi instalasi yang menjadi referensi saat pemeriksaan dan perbaikan.', 'en' => 'True. As-built drawings show the installed condition and are used as references during inspection and repair.'],
                'topic_tag' => 'As-Built Diagram',
                'options' => [
                    [['id' => 'Benar', 'en' => 'True'], true],
                    [['id' => 'Salah', 'en' => 'False'], false],
                ],
            ],
            [
                'question_text' => ['id' => 'Jelaskan mengapa teknisi perlu memahami simbol dan penomoran terminal pada gambar elektrikal Garbarata.', 'en' => 'Explain why technicians need to understand symbols and terminal numbering in Garbarata electrical drawings.'],
                'type' => 'essay',
                'points' => 15,
                'explanation' => ['id' => 'Pemahaman simbol dan nomor terminal membantu teknisi mengidentifikasi komponen, menelusuri jalur kabel, menghindari salah sambung, dan mempercepat troubleshooting.', 'en' => 'Understanding symbols and terminal numbers helps technicians identify components, trace wiring routes, avoid incorrect connections, and speed up troubleshooting.'],
                'topic_tag' => 'Simbol Elektrikal',
                'options' => [],
            ],
            [
                'question_text' => ['id' => 'Jodohkan elemen gambar elektrikal berikut dengan kegunaannya.', 'en' => 'Match each electrical drawing element with its purpose.'],
                'type' => 'matching',
                'points' => 3,
                'explanation' => ['id' => 'Simbol komponen menunjukkan perangkat, nomor terminal menunjukkan titik sambungan, dan jalur kabel menunjukkan koneksi antar komponen.', 'en' => 'Component symbols indicate devices, terminal numbers indicate connection points, and wiring lines indicate connections between components.'],
                'topic_tag' => 'Pembacaan Diagram',
                'options' => [
                    [['id' => 'Simbol komponen', 'en' => 'Component symbol'], true, ['id' => 'Menunjukkan perangkat pada rangkaian', 'en' => 'Indicates a device in the circuit']],
                    [['id' => 'Nomor terminal', 'en' => 'Terminal number'], true, ['id' => 'Menunjukkan titik sambungan kabel', 'en' => 'Indicates a cable connection point']],
                    [['id' => 'Jalur kabel', 'en' => 'Wiring line'], true, ['id' => 'Menunjukkan hubungan antar komponen', 'en' => 'Indicates connections between components']],
                ],
            ],
            [
                'question_text' => ['id' => 'Urutkan langkah dasar membaca gambar elektrikal sebelum melakukan troubleshooting pada Garbarata.', 'en' => 'Arrange the basic steps for reading an electrical drawing before troubleshooting Garbarata.'],
                'type' => 'ordering',
                'points' => 3,
                'explanation' => ['id' => 'Langkah dasar adalah menentukan lembar gambar, mencari komponen, menelusuri jalur kabel dan terminal, lalu mencocokkan dengan kondisi aktual di lapangan.', 'en' => 'The basic steps are selecting the drawing sheet, finding the component, tracing wiring and terminals, then comparing them with the actual field condition.'],
                'topic_tag' => 'Troubleshooting Elektrikal',
                'options' => [
                    [['id' => 'Tentukan lembar gambar yang sesuai dengan sistem yang diperiksa', 'en' => 'Select the drawing sheet related to the system being checked'], true],
                    [['id' => 'Cari simbol atau kode komponen pada gambar', 'en' => 'Find the component symbol or code on the drawing'], true],
                    [['id' => 'Telusuri jalur kabel dan nomor terminal', 'en' => 'Trace the wiring route and terminal numbers'], true],
                    [['id' => 'Cocokkan hasil pembacaan dengan kondisi aktual di panel atau unit', 'en' => 'Compare the reading with the actual condition in the panel or unit'], true],
                ],
            ],
        ];

        $this->createQuestions($chapter, $items);
    }

    private function createQuestions(Chapter $chapter, array $items): void
    {
        foreach ($items as $index => $item) {
            $question = Question::create([
                'course_id' => $chapter->course_id,
                'chapter_id' => $chapter->id,
                'question_text' => $item['question_text'],
                'type' => $item['type'],
                'points' => $item['points'],
                'explanation' => $item['explanation'],
                'topic_tag' => $item['topic_tag'],
                'order' => $index + 1,
            ]);

            foreach ($item['options'] as $order => $option) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option[0],
                    'is_correct' => $option[1],
                    'match_label' => $option[2] ?? null,
                    'order' => $order,
                ]);
            }
        }
    }
}
