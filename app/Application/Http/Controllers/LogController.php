<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\LogResource;
use App\Domain\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    private LogService $LogService;

    public function __construct(LogService $LogService)
    {
        $this->LogService = $LogService;
    }

    public function getAllAction(): LogResource
    {
        $logs = $this->LogService->getAllAction();
        return new LogResource($logs);
    }

    public function getAllAffectedUser(): LogResource
    {
        $logs = $this->LogService->getAllAffectedUser();
        return new LogResource($logs);
    }

    public function getAllUser(): LogResource
    {
        $logs = $this->LogService->getAllUser();
        return new LogResource($logs);
    }

}
