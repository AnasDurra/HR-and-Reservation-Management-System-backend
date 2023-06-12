<?php


namespace App\Domain\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function getUserList(): array;

    public function createUser(array $data): Builder|Model;

}
