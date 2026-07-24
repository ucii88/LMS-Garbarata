<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            ChapterSeeder::class,
            Chapter1Seeder::class,
            Chapter1QuestionSeeder::class,
            Chapter2Seeder::class,
            Chapter2QuestionSeeder::class,
            Chapter3Seeder::class,
            Chapter3QuestionSeeder::class,
            Chapter4Seeder::class,
            Chapter4QuestionSeeder::class,
            Chapter5Seeder::class,
            Chapter5QuestionSeeder::class,
            Chapter6Seeder::class,
            Chapter6QuestionSeeder::class,
            Chapter7Seeder::class,
            Chapter7QuestionSeeder::class,
            EnglishContentSeeder::class,
            QuestionTranslationSeeder::class,
        ]);
    }
}


