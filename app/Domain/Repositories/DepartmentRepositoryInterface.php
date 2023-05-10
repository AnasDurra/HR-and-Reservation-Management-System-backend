<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Department;

interface DepartmentRepositoryInterface
{
    public function getList(): array;

    public function getById(int $id): ?Department;

    public function create(array $data): Department;

    public function update(int $id, array $data): Department;

    public function delete($id): Department;
}
