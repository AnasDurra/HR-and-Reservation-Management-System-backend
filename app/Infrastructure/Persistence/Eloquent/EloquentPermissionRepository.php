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

}
