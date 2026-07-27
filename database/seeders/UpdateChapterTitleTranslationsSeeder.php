<?php

namespace Database\Seeders;

use App\Models\Chapter;
use Illuminate\Database\Seeder;

class UpdateChapterTitleTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            1 => [
                1 => ['id' => '1.1 Rotunda', 'en' => '1.1 Rotunda'],
                2 => ['id' => '1.2 Telescopic Tunnel', 'en' => '1.2 Telescopic Tunnel'],
                3 => ['id' => '1.3 Vertical Lift Column', 'en' => '1.3 Vertical Lift Column'],
                4 => ['id' => '1.4 Wheel Boogie', 'en' => '1.4 Wheel Boogie'],
                5 => ['id' => '1.5 Service Access', 'en' => '1.5 Service Access'],
                6 => ['id' => '1.6 Cabin', 'en' => '1.6 Cabin'],
                7 => ['id' => '2.1 Main-Distribution Panel', 'en' => '2.1 Main Distribution Panel'],
                8 => ['id' => '2.2 Distribution Power Panel', 'en' => '2.2 Distribution Power Panel'],
                9 => ['id' => '2.3 Console Desk', 'en' => '2.3 Console Desk'],
                10 => ['id' => '2.4 Pencahayaan', 'en' => '2.4 Lighting'],
                11 => ['id' => '2.5 Safety Device / Sensor / Actuator', 'en' => '2.5 Safety Device / Sensor / Actuator'],
            ],
            3 => [
                1 => ['id' => '1.1 Deskripsi Detail Pengoperasian', 'en' => '1.1 Detailed Operating Description'],
                2 => ['id' => '2.1 Penggerak Horizontal', 'en' => '2.1 Horizontal Drive'],
                3 => ['id' => '2.2 Rotasi Kabin', 'en' => '2.2 Cabin Rotation'],
                4 => ['id' => '2.3 Penggerak Vertikal', 'en' => '2.3 Vertical Drive'],
                5 => ['id' => '2.4 Penggerak Canopy', 'en' => '2.4 Canopy Drive'],
                6 => ['id' => '3. Mode Auto (Autolevel)', 'en' => '3. Auto Mode (Autolevel)'],
                7 => ['id' => '4.1 Prosedur Pengoperasian Standar (Mode Manual)', 'en' => '4.1 Standard Operating Procedure (Manual Mode)'],
                8 => ['id' => '4.2 Prosedure Standar Operasi (Auto Mode)', 'en' => '4.2 Standard Operating Procedure (Auto Mode)'],
                9 => ['id' => '4.3 Prosedur Pengoperasian Darurat', 'en' => '4.3 Emergency Operating Procedure'],
                10 => ['id' => '4.4 Parkir', 'en' => '4.4 Parking'],
                11 => ['id' => '4.5 Penggunaan Jacking Stand', 'en' => '4.5 Use of Jacking Stand'],
                12 => ['id' => '4.6 Malfungsi Pergerakan atau Fault Power Garbarata', 'en' => '4.6 Garbarata Movement Malfunction or Power Failure'],
            ],
        ];

        foreach ($titles as $chapterOrder => $moduleTitles) {
            $chapter = Chapter::where('order', $chapterOrder)->first();

            if (!$chapter) {
                continue;
            }

            foreach ($moduleTitles as $moduleOrder => $title) {
                $chapter->modules()->where('order', $moduleOrder)->update(['title' => json_encode($title)]);
            }
        }
    }
}
