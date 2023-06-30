<?php

namespace App\Domain\Services;

use App\Domain\Repositories\AuthenticationRepositoryInterface;
use Illuminate\Support\Collection;

class AuthenticationService
{
    private AuthenticationRepositoryInterface $AuthenticationRepository;

    public function __construct(AuthenticationRepositoryInterface $AuthenticationRepository)
    {
        $this->AuthenticationRepository = $AuthenticationRepository;
    }

    public function employeeLogin(array $credentials): string
    {
        return $this->AuthenticationRepository->employeeLogin($credentials);
    }

    public function employeeLogout(): void
    {
        $this->AuthenticationRepository->employeeLogout();
    }

    public function getEmployeeActivePermissionsByToken(): Collection
    {
        return $this->AuthenticationRepository->getEmployeeActivePermissionsByToken();
    }
}
