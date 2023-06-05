<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

interface PermissionRepositoryInterface
{
    public function getPermissionList(): array;

    public function getPermissionById(int $id): Permission|Builder|null;

}
