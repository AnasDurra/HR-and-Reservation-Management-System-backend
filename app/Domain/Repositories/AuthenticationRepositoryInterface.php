<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

interface AuthenticationRepositoryInterface
{
    public function employeeLogin(array $credentials): string;

    public function employeeLogout(): void;

    public function getEmployeeActivePermissionsByToken(): Collection;

}
