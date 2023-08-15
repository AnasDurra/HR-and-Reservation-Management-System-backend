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

    public function employeeLogin(array $credentials): array
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

    public function consultantLogin(array $credentials): array
    {
        return $this->AuthenticationRepository->consultantLogin($credentials);
    }

    public function consultantLogout(): void
    {
        $this->AuthenticationRepository->consultantLogout();
    }

    public function getConsultantActivePermissionsByToken(): Collection
    {
        return $this->AuthenticationRepository->getConsultantActivePermissionsByToken();
    }
}
