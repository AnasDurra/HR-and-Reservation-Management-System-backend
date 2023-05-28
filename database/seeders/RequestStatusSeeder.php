<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Shift Request Status: (in Arabic)
        //     - pending
        //     - accepted
        //     - rejected

        $requestStatuses = [
            ['name' => 'بانتظار المعالجة', 'description' => 'حالة الطلب: بانتظار المعالجة'],
            ['name' => 'مقبول', 'description' => 'حالة الطلب: مقبول'],
            ['name' => 'مرفوض', 'description' => 'حالة الطلب: مرفوض'],
        ];
        DB::table('request_statuses')
            ->insert($requestStatuses);
    }
}
