<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Chapter2Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 2)->first();

        if (!$chapter) {
            return;
        }

       
    }
}
