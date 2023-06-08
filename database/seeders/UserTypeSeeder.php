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
                'name' => 'employee',
                'description' => 'Center Employee',
            ],

            // TODO: Add Consultant
        ];

        foreach ($userTypes as $userType) {
            UserType::query()->create($userType);
        }
    }
}
