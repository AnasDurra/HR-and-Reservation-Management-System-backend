<?php

namespace App\Domain\Services;

use App\Domain\Models\CD\Customer;
use App\Domain\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    private CustomerRepositoryInterface $CustomerRepository;

    public function __construct(CustomerRepositoryInterface $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function getCustomerList(): LengthAwarePaginator
    {
        return $this->CustomerRepository->getCustomerList();
    }

    public function getCustomerById(int $id): Customer|Builder|null
    {
        return $this->CustomerRepository->getCustomerById($id);
    }

    public function updateCustomer(int $id, array $data): Customer|Builder|null
    {
        return $this->CustomerRepository->updateCustomer($id, $data);
    }

    public function deleteCustomer($id): Customer|Builder|null
    {
        return $this->CustomerRepository->delete($id);
    }

    public function userSingUp(array $data): array
    {
        return $this->CustomerRepository->userSingUp($data);
    }

    public function userLogin(array $data): array
    {
        return $this->CustomerRepository->userLogin($data);
    }

    public function userLogout(): void
    {
        $this->CustomerRepository->userLogout();
    }

    public function customersMissedAppointments(): LengthAwarePaginator
    {
        return $this->CustomerRepository->customersMissedAppointments();
    }

    public function customerToggleStatus(int $id): Customer|Builder|null
    {
        return $this->CustomerRepository->customerToggleStatus($id);
    }
}
