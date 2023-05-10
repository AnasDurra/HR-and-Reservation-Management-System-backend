<?php

namespace App\Domain\Services;

use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Models\Department;

class DepartmentService
{
    /** @var DepartmentRepositoryInterface */
    private $DepartmentRepository;

    public function __construct(DepartmentRepositoryInterface $DepartmentRepository)
    {
        $this->DepartmentRepository = $DepartmentRepository;
    }

    public function getList(): array
    {
        return $this->DepartmentRepository->getList();
    }

    public function getById(int $id): ?Department
    {
        return $this->DepartmentRepository->getById($id);
    }

    public function create(array $data): Department
    {
        return $this->DepartmentRepository->create($data);
    }

    public function update(int $id, array $data): Department
    {
        return $this->DepartmentRepository->update($id, $data);
    }

    public function delete($id): Department
    {
        return $this->DepartmentRepository->delete($id);
    }
}
