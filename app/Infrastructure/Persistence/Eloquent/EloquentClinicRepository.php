<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ClinicRepositoryInterface;
use App\Domain\Models\CD\Clinic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentClinicRepository implements ClinicRepositoryInterface
{
    public function getClinicList(): Collection
    {
        return Clinic::query()->get();
    }

    public function getClinicById(int $id): Clinic|Builder|null
    {
        // TODO: Implement the logic to retrieve a Clinic by ID
    }

    public function createClinic(array $data): Clinic|Builder|null
    {
        // TODO: Implement the logic to create a Clinic
    }

    public function updateClinic(int $id, array $data): Clinic|Builder|null
    {
        // TODO: Implement the logic to update a Clinic
    }

    public function deleteClinic($id): Clinic|Builder|null
    {
        // TODO: Implement the logic to delete a Clinic
    }
}
