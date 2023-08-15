<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

interface AuthenticationRepositoryInterface
{
    public function employeeLogin(array $credentials): array;

    public function employeeLogout(): void;

    public function getEmployeeActivePermissionsByToken(): Collection;

    public function consultantLogin(array $credentials): array;

    public function consultantLogout(): void;

    public function getConsultantActivePermissionsByToken(): Collection;

}
