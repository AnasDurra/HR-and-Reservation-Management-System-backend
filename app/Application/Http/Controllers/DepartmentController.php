<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\DepartmentResource;
use App\Domain\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    private DepartmentService $DepartmentService;

    public function __construct(DepartmentService $DepartmentService)
    {
        $this->DepartmentService = $DepartmentService;
    }

    public function index(): JsonResponse
    {
        $items = $this->DepartmentService->getList();
        return response()->json([
            'data'=>DepartmentResource::collection($items)]
            ,200);
    }

    public function show(int $id): JsonResponse
    {
        $item = $this->DepartmentService->getById($id);
        if (!$item) {
            return response()->json(['message'=>'Department not found']
                , 404);
        }
        return response()->json([
            'data'=>new DepartmentResource($item)
            ], 200);
    }

    public function store(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required','max:50','string','unique:departments,name'],
            'description' =>['max:255','string']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'data'=>new DepartmentResource($errors)
            ], 400);
        }
        $item = $this->DepartmentService->create(request()->all());
        return response()->json([
            'data'=>new DepartmentResource($item)
        ], 201);

    }

    public function update(int $id): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['max:50','string','unique:departments,name,' . $id . ',dep_id'],
            'description' =>['max:255','string']
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'data'=>new DepartmentResource($errors)
                ], 400);
        }

        $item = $this->DepartmentService->getById($id);
        if (!$item) {
            return response()->json(['message'=>'Department not found']
                , 404);
        }
        $item = $this->DepartmentService->update($id, request()->all());
        return response()->json([
            'data'=>new DepartmentResource($item)
        ], 200);

    }

    public function destroy(int $id): JsonResponse
    {
        $item = $this->DepartmentService->getById($id);
        if (!$item) {
            return response()->json(['message'=>'Department not found']
                , 404);
        }
        $item = $this->DepartmentService->delete($id);
        return response()->json([
            'data'=>new DepartmentResource($item),
        ],200);
    }
}
