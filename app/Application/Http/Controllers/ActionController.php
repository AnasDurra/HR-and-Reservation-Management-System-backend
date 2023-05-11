<?php
namespace App\Application\Http\Controllers;
use App\Application\Http\Resources\ActionResource;
use App\Domain\Services\ActionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    private $ActionService;

    public function __construct(ActionService $ActionService)
    {
        $this->ActionService = $ActionService;
    }

    public function index(): JsonResponse
    {
        $actions = $this->ActionService->getActionList();
        return response()->json([
            'data'=>ActionResource::collection($actions) //Modify it as needed
            ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $action = $this->ActionService->getActionById($id);
        return response()->json([
            'data'=> new ActionResource($action) //Modify it as needed
            ], 200);
    }

    public function store(): JsonResponse
    {
        $action = $this->ActionService->createAction(request()->all());
        return response()->json([
            'data'=> new ActionResource($action) //Modify it as needed
            ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $action = $this->ActionService->updateAction($id, request()->all());
        return response()->json([
            'data'=> new ActionResource($action) //Modify it as needed
            ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $action = $this->ActionService->deleteAction($id);
        return response()->json([
            'data'=> new ActionResource($action) //Modify it as needed
            ], 200);
    }
}