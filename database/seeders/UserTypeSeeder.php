<?php

namespace Database\Seeders;

use App\Domain\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            // employee
            [
                'name' => 'موظف',
                'description' => 'موظف يعمل ضمن المركز',
            ],

            // TODO: Add Consultant
        ];

        foreach ($userTypes as $userType) {
            UserType::query()->create($userType);
        }
    }
}
