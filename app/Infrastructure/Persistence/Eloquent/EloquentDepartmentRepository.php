<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Models\Department;

class EloquentDepartmentRepository implements DepartmentRepositoryInterface
{
    public function getList(): array
    {
        return Department::all()->toArray();
    }

    public function getById(int $id): ?Department
    {
        $department = Department::find($id);
        return $department;
    }

    public function create(array $data): Department
    {
        $department= Department::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        return $department;
    }

    public function update(int $id, array $data): Department
    {
        $department = Department::find($id);
        $department->name = $data['name'] ?? $department->name;
        $department->description = $data['description'] ?? $department->description;
        $department->save();
        return $department;
    }

    public function delete($id): Department
    {
        $department =Department::find($id);
        Department::find($id)->delete();
        return $department;
    }
}
