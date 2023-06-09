<?php

namespace Database\Seeders;

use App\Domain\Models\JobVacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed a new job vacancy
        JobVacancy::query()->create([
            'name' => 'مدير موارد بشرية',
            'description' => 'مدير موارد بشرية',
        ]);
    }
}
