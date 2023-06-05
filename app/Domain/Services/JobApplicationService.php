<?php


namespace App\Domain\Services;


use App\Domain\Repositories\JobApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JobApplicationService
{
    private JobApplicationRepositoryInterface $jobApplicationRepository;

    public function __construct(JobApplicationRepositoryInterface $jobApplicationRepository)
    {
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    public function getJobApplicationsList(): array
    {
        return $this->jobApplicationRepository->getJobApplicationsList();
    }

    public function getJobApplicationById(int $id): Builder|Model
    {
        return $this->jobApplicationRepository->getJobApplicationById($id);
    }

    public function createJobApplication(array $data): Builder|Model
    {
        return $this->jobApplicationRepository->createJobApplication($data);
    }

    public function updateJobApplication(int $id, array $data): bool
    {
        return $this->jobApplicationRepository->updateJobApplication($id, $data);
    }

    public function deleteJobApplication($id): bool
    {
        return $this->jobApplicationRepository->deleteJobApplication($id);
    }

    public function acceptJobApplicationRequest($id): Model|Builder
    {
        return $this->jobApplicationRepository->acceptJobApplicationRequest($id);
    }

    public function rejectJobApplicationRequest($id): Model|Builder
    {
        return $this->jobApplicationRepository->rejectJobApplicationRequest($id);
    }
}
