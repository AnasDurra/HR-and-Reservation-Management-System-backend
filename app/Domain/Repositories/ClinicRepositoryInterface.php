<?php

namespace App\Domain\Repositories;

use App\Domain\Models\CD\Clinic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface ClinicRepositoryInterface
{
    public function getClinicList(): Collection;

    public function getClinicById(int $id): Clinic|Builder|null;

    public function createClinic(array $data): Clinic|Builder|null;

    public function updateClinic(int $id, array $data): Clinic|Builder|null;

    public function deleteClinic($id): Clinic|Builder|null;
}
