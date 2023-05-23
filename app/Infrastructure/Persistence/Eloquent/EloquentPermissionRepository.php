<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\PermissionRepositoryInterface;
use App\Domain\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

class EloquentPermissionRepository implements PermissionRepositoryInterface
{
    public function getPermissionList(): array
    {
        return Permission::all()->toArray();
    }

    public function getPermissionById(int $id): Permission|Builder|null
    {
        return Permission::query()->find($id);
    }

//    public function createPermission(array $data): Permission|Builder|null
//    {
//        // TODO: Implement the logic to create a Permission
//    }

//    public function updatePermission(int $id, array $data): Permission|Builder|null
//    {
//        // TODO: Implement the logic to update a Permission
//    }

//    public function deletePermission($id): Permission|Builder|null
//    {
//        // TODO: Implement the logic to delete a Permission
//    }
}
