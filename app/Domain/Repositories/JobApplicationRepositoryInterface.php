<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface JobApplicationRepositoryInterface
{
    public function getJobApplicationsList(): array;

    public function getJobApplicationById(int $id): Builder|Model|null;

    public function createJobApplication(array $data): Builder|Model;

    public function updateJobApplication(int $id, array $data): bool;

    public function deleteJobApplication($id): bool;

    public function acceptJobApplicationRequest($id): Model|Builder;

    public function rejectJobApplicationRequest($id): Model|Builder;
}
