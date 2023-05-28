<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('education_levels')
            ->insert([
                ['name' => 'ابتدائي', 'description' => 'المستوى التعليمي: ابتدائي'],
                ['name' => 'إعدادي', 'description' => 'المستوى التعليمي: إعدادي'],
                ['name' => 'ثانوي', 'description' => 'المستوى التعليمي: ثانوي'],
                ['name' => 'دبلوم بعد الثانوية', 'description' => 'المستوى التعليمي: دبلوم بعد الثانوية'],
                ['name' => 'الجامعة', 'description' => 'المستوى التعليمي: الجامعة'],
                ['name' => 'دراسات عليا', 'description' => 'المستوى التعليمي: دراسات عليا'],
            ]);
    }
}
