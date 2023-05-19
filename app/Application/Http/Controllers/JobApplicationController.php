<?php


namespace App\Application\Http\Controllers;


use App\Application\Http\Requests\StoreJobApplicationRequest;
use App\Application\Http\Resources\JobApplicationBriefResource;
use App\Application\Http\Resources\JobApplicationDetailsResource;
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
        return JobApplicationBriefResource::collection($jobApplications);
    }

    public function show(int $id): JobApplicationDetailsResource
    {
        $jobApplication = $this->jobApplicationService->getJobApplicationById($id);
        return new JobApplicationDetailsResource($jobApplication);
    }

    public function store(StoreJobApplicationRequest $request): JobApplicationBriefResource
    {
        // validate request data
        $validated = $request->validated();

        // create job application
        $jobApplication = $this->jobApplicationService->createJobApplication($validated);

        // return job application in json format
        return new JobApplicationBriefResource($jobApplication);
    }

    public function update(int $id): JobApplicationBriefResource
    {
        $employee = $this->jobApplicationService->updateJobApplication($id, request()->all());
        return new JobApplicationBriefResource($employee);
    }

    public function destroy(int $id): JobApplicationBriefResource
    {
        $employee = $this->jobApplicationService->deleteJobApplication($id);
        return new JobApplicationBriefResource($employee);
    }
}
