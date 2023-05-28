<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface JobApplicationRepositoryInterface
{
    public function getJobApplicationsList(): Collection;

    public function getJobApplicationById(int $id): Builder|array|Collection|Model;

    public function createJobApplication(array $data): Builder|Model;

    public function updateJobApplication(int $id, array $data): bool;

    public function deleteJobApplication($id): bool;
}
