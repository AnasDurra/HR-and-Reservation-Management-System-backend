<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\ConsultantLoginRequest;
use App\Application\Http\Requests\EmployeeLoginRequest;
use App\Domain\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    private AuthenticationService $AuthenticationService;

    public function __construct(AuthenticationService $AuthenticationService)
    {
        $this->AuthenticationService = $AuthenticationService;
    }

    // Employee Login route
    public function employeeLogin(EmployeeLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'username', 'password']);
        $data = $this->AuthenticationService->employeeLogin($credentials);
        return response()->json($data);
    }

    // Employee Logout route
    public function employeeLogout(): JsonResponse
    {
        $this->AuthenticationService->employeeLogout();
        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    // Retrieve Employee by token route
    public function getEmployeeActivePermissionsByToken(): JsonResponse
    {
        $activePermissions = $this->AuthenticationService->getEmployeeActivePermissionsByToken();
        return response()->json([
            'message' => 'تم استرجاع الصلاحيات بنجاح',
            'active_permissions' => $activePermissions,
        ]);
    }


    // Consultant Login route
    public function consultantLogin(ConsultantLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'username', 'password']);
        $data = $this->AuthenticationService->consultantLogin($credentials);
        return response()->json($data);
    }

    // Consultant Logout route
    public function consultantLogout(): JsonResponse
    {
        $this->AuthenticationService->consultantLogout();
        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    // Retrieve Consultant by token route
    public function getConsultantActivePermissionsByToken(): JsonResponse
    {
        $activePermissions = $this->AuthenticationService->getConsultantActivePermissionsByToken();
        return response()->json([
            'message' => 'تم استرجاع الصلاحيات بنجاح',
            'active_permissions' => $activePermissions,
        ]);
    }

}
