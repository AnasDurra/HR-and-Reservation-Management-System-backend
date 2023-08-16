<?php

namespace Database\Seeders;

use App\Domain\Models\CD\AppointmentStatus;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $status = [
            'تم الإلغاء بواسطة المراجع',
            'تم الإلغاء بواسطة الموظف',
            'تم الإلغاء بواسطة المستشار',
            'مكتمل',
            'محجوز',
            'متاح',
            'الموعد فائت من قبل المراجع',
            'الموعد فائت من قبل المستشار',
        ];

        foreach ($status as $item) {
            AppointmentStatus::create([
                'name' => $item,
            ]);
        }
    }
}
