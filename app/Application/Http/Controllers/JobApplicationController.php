<?php


namespace App\Application\Http\Controllers;


use App\Application\Http\Requests\StoreJobApplicationRequest;
use App\Application\Http\Resources\JobApplicationResource;
use App\Domain\Services\JobApplicationService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobApplicationController extends Controller
{
    private JobApplicationService $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    public function index(): AnonymousResourceCollection
    {
        $jobApplications = $this->jobApplicationService->getJobApplicationsList();
        return JobApplicationResource::collection($jobApplications);
    }

    public function show(int $id): JobApplicationResource
    {
        $jobApplication = $this->jobApplicationService->getJobApplicationById($id);
        return new JobApplicationResource($jobApplication);
    }

    public function store(StoreJobApplicationRequest $request): JobApplicationResource
    {
        // validate request data
        $validated = $request->validated();

        // create job application
        $jobApplication = $this->jobApplicationService->createJobApplication($validated);

        // return job application in json format
        return new JobApplicationResource($jobApplication);
    }

    public function update(int $id): JobApplicationResource
    {
        $employee = $this->jobApplicationService->updateJobApplication($id, request()->all());
        return new JobApplicationResource($employee);
    }

    public function destroy(int $id): JobApplicationResource
    {
        $employee = $this->jobApplicationService->deleteJobApplication($id);
        return new JobApplicationResource($employee);
    }
}
