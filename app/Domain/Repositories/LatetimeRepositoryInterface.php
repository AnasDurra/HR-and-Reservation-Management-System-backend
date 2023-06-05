<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Latetime;
use Illuminate\Database\Eloquent\Builder;

interface LatetimeRepositoryInterface
{
    public function getLatetimeList(): array;

    public function getLatetimeById(int $id): Latetime|Builder|null;

    public function createLatetime(array $data): Latetime|Builder|null;

    public function updateLatetime(int $id, array $data): Latetime|Builder|null;

    public function deleteLatetime($id): Latetime|Builder|null;

    public function getEmployeeLateByDate($emp_id,$date): Latetime|Builder|null;
}
