<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function getCustomerList(): LengthAwarePaginator;

    public function getCustomerById(int $id): Customer|Builder|null;

    public function updateCustomer(int $id, array $data): Customer|Builder|null;

    public function userSingUp(array $data): array;

    public function userLogin(array $data): array;

    public function userLogout(): void;
}
