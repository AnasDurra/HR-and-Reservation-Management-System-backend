<?php

namespace Database\Seeders;

use App\Domain\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * TODO: Create a seeder for the permissions table
         * in Arabic
         * Manage Departments
         * Manage Job Vacancies
         * Manage Job Titles
         * Manage Employee Schedules
         * Manage Job Applications
         * Manage Employees
         * Manage Logs
         * Generate Report
         **/

        $permissions = [
            [
                'name' => 'إدارة الأقسام',
            ],
            [
                'name' => 'إدارة الشواغر الوظيفيّة',
            ],
            [
                'name' => 'إدارة المسمّيات الوظيفيّة',
            ],
            [
                'name' => 'إدارة الدوام',
            ],
            [
                'name' => 'إدارة طلبات التوظيف',
            ],
            [
                'name' => 'إدارة الموظفين',
            ],
            [
                'name' => 'إدارة سجل الأحداث',
            ],
            [
                'name' => 'إصدار التقارير',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->create([
                'name' => $permission['name'],
                'description' => '',
            ]);
        }
    }
}
