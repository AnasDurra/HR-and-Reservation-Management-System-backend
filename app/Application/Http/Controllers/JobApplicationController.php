<?php


namespace App\Application\Http\Controllers;


use App\Application\Http\Requests\StoreJobApplicationRequest;
use App\Application\Http\Requests\UpdateJobApplicationRequest;
use App\Application\Http\Resources\JobApplicationBriefResource;
use App\Application\Http\Resources\JobApplicationDetailsResource;
use App\Domain\Services\JobApplicationService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;


class JobApplicationController extends Controller
{
    private JobApplicationService $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    // implement get all job applications with pagination
    public function index(): AnonymousResourceCollection
    {
        $jobApplications = $this->jobApplicationService->getJobApplicationsList();
        return JobApplicationBriefResource::collection($jobApplications);
    }

    /**
     * @throws Throwable
     */
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

    public function update(UpdateJobApplicationRequest $request, int $id): JobApplicationDetailsResource
    {
        $employee = $this->jobApplicationService->updateJobApplication($id, $request->validated());
        return new JobApplicationDetailsResource($employee);
    }

    public function destroy(int $id): JobApplicationBriefResource
    {

        // delete job application
        $employee = $this->jobApplicationService->deleteJobApplication($id);
        return new JobApplicationBriefResource($employee);
    }
}
