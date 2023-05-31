<?php

namespace App\Domain\Services;

use App\Domain\Repositories\PermissionRepositoryInterface;
use App\Domain\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

class PermissionService
{
    /** @var PermissionRepositoryInterface */
    private $PermissionRepository;

    public function __construct(PermissionRepositoryInterface $PermissionRepository)
    {
        $this->PermissionRepository = $PermissionRepository;
    }

    public function getPermissionList(): array
    {
        return $this->PermissionRepository->getPermissionList();
    }

    public function getPermissionById(int $id): Permission|Builder|null
    {
        return $this->PermissionRepository->getPermissionById($id);
    }

//    public function createPermission(array $data): Permission|Builder|null
//    {
//        return $this->PermissionRepository->createPermission($data);
//    }

//    public function updatePermission(int $id, array $data): Permission|Builder|null
//    {
//        return $this->PermissionRepository->updatePermission($id, $data);
//    }

//    public function deletePermission($id): Permission|Builder|null
//    {
//        return $this->PermissionRepository->deletePermission($id);
//    }
}
