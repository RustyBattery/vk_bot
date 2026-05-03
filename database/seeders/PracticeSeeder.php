<?php

namespace Database\Seeders;

use App\Models\Practice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $practices = [
            ['name' => 'Дыхание для расслабления'],
            ['name' => 'Прогрессивная мышечная релаксация'],
            ['name' => 'Техника заземления «5–4–3–2–1»'],
            ['name' => 'Техника «Безопасное место»'],
        ];

        foreach ($practices as $practice) {
            Practice::create($practice);
        }
    }
}
