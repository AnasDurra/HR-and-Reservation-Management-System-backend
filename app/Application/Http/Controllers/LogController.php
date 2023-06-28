<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\LogResource;
use App\Domain\Services\LogService;
use App\Http\Resources\AffectedUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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

    public function getAllAffectedUser(): AnonymousResourceCollection
    {
        $logs = $this->LogService->getAllAffectedUser();
        return AffectedUserResource::collection($logs);
    }

    public function getAllUser(): AnonymousResourceCollection
    {
        $logs = $this->LogService->getAllUser();
        return AffectedUserResource::collection($logs);
    }

}
