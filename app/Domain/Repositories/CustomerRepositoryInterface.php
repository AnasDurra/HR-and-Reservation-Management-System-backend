<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

interface CustomerRepositoryInterface
{
    public function getCustomerList(): array;

    public function getCustomerById(int $id): Customer|Builder|null;

    public function updateCustomer(int $id, array $data): Customer|Builder|null;

    public function deleteCustomer($id): Customer|Builder|null;

    public function userSingUp(array $data): array;

    public function userLogin(array $data): array;

    public function userLogout(): void;
}
