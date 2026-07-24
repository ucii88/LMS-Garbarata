<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class Chapter6QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 6)->first();
        if (!$chapter) return;

        $questions = Question::where('chapter_id', $chapter->id)->get();
        foreach ($questions as $q) {
            $q->options()->delete();
            $q->delete();
        }

        $items = [
            [
                'question_text' => ['id' => 'Katalog Cyclo 6000 digunakan untuk melihat informasi teknis apa pada sistem penggerak Garbarata?', 'en' => 'What technical information for the Garbarata drive system is provided in the Cyclo 6000 catalog?'],
                'type' => 'multiple_choice',
                'points' => 5,
                'explanation' => ['id' => 'Katalog Cyclo 6000 berisi spesifikasi reducer/gearbox seperti rasio, torsi, dimensi, dan data unit penggerak.', 'en' => 'The Cyclo 6000 catalog contains reducer/gearbox specifications such as ratio, torque, dimensions, and drive unit data.'],
                'topic_tag' => 'Cyclo 6000',
                'options' => [
                    [['id' => 'Spesifikasi reducer atau gearbox', 'en' => 'Reducer or gearbox specifications'], true],
                    [['id' => 'Jadwal kerja operator harian', 'en' => 'Daily operator work schedule'], false],
                    [['id' => 'Daftar penumpang pesawat', 'en' => 'Aircraft passenger list'], false],
                    [['id' => 'Prosedur boarding manual', 'en' => 'Manual boarding procedure'], false],
                ],
            ],
            [
                'question_text' => ['id' => 'Dokumen Warner Installation & Operation Manual termasuk dokumen pendukung untuk komponen sistem kontrol dan penggerak Garbarata.', 'en' => 'The Warner Installation & Operation Manual is a supporting document for Garbarata control and drive system components.'],
                'type' => 'true_false',
                'points' => 5,
                'explanation' => ['id' => 'Benar. Dokumen Warner digunakan sebagai panduan instalasi dan operasi komponen yang berkaitan dengan sistem kontrol dan penggerak.', 'en' => 'True. The Warner document is used as an installation and operation guide for components related to the control and drive system.'],
                'topic_tag' => 'Warner Manual',
                'options' => [
                    [['id' => 'Benar', 'en' => 'True'], true],
                    [['id' => 'Salah', 'en' => 'False'], false],
                ],
            ],
            [
                'question_text' => ['id' => 'Jelaskan fungsi katalog teknis dalam proses pemeliharaan dan penggantian komponen Garbarata.', 'en' => 'Explain the function of technical catalogs in Garbarata maintenance and component replacement.'],
                'type' => 'essay',
                'points' => 15,
                'explanation' => ['id' => 'Katalog teknis membantu teknisi memastikan spesifikasi, dimensi, kapasitas, part number, dan batas penggunaan komponen sebelum inspeksi, perawatan, atau penggantian dilakukan.', 'en' => 'Technical catalogs help technicians verify specifications, dimensions, capacity, part numbers, and component limits before inspection, maintenance, or replacement is performed.'],
                'topic_tag' => 'Katalog Teknis',
                'options' => [],
            ],
            [
                'question_text' => ['id' => 'Jodohkan dokumen katalog berikut dengan informasi utama yang dapat diperoleh dari dokumen tersebut.', 'en' => 'Match each catalog document with the main information that can be obtained from it.'],
                'type' => 'matching',
                'points' => 3,
                'explanation' => ['id' => 'Cyclo 6000 berkaitan dengan reducer/gearbox, HIWIN LAS Series dengan linear guideway, dan Rooftop Packaged Air Conditioners dengan unit AC rooftop.', 'en' => 'Cyclo 6000 relates to reducers/gearboxes, HIWIN LAS Series to linear guideways, and Rooftop Packaged Air Conditioners to rooftop AC units.'],
                'topic_tag' => 'Identifikasi Katalog',
                'options' => [
                    [['id' => 'Cyclo 6000', 'en' => 'Cyclo 6000'], true, ['id' => 'Reducer atau gearbox', 'en' => 'Reducer or gearbox']],
                    [['id' => 'HIWIN LAS Series', 'en' => 'HIWIN LAS Series'], true, ['id' => 'Linear guideway', 'en' => 'Linear guideway']],
                    [['id' => 'Rooftop Packaged Air Conditioners', 'en' => 'Rooftop Packaged Air Conditioners'], true, ['id' => 'Unit pendingin udara rooftop', 'en' => 'Rooftop air conditioning unit']],
                ],
            ],
            [
                'question_text' => ['id' => 'Urutkan langkah penggunaan dokumen katalog teknis saat teknisi akan melakukan penggantian komponen.', 'en' => 'Arrange the steps for using a technical catalog when a technician is going to replace a component.'],
                'type' => 'ordering',
                'points' => 3,
                'explanation' => ['id' => 'Langkah yang benar adalah identifikasi komponen, buka katalog terkait, cocokkan spesifikasi/part number, lalu pastikan komponen pengganti sesuai sebelum pemasangan.', 'en' => 'The correct steps are identifying the component, opening the related catalog, matching the specifications/part number, then confirming the replacement component before installation.'],
                'topic_tag' => 'Prosedur Katalog',
                'options' => [
                    [['id' => 'Identifikasi komponen yang akan diperiksa atau diganti', 'en' => 'Identify the component to inspect or replace'], true],
                    [['id' => 'Buka katalog teknis yang sesuai dengan komponen', 'en' => 'Open the technical catalog related to the component'], true],
                    [['id' => 'Cocokkan spesifikasi, dimensi, dan part number', 'en' => 'Match the specifications, dimensions, and part number'], true],
                    [['id' => 'Pastikan komponen pengganti sesuai sebelum dipasang', 'en' => 'Confirm the replacement component before installation'], true],
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
