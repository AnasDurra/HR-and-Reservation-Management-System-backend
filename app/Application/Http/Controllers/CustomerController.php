<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\AddCustomerRequest;
use App\Application\Http\Requests\EditCustomerAfterVerification;
use App\Application\Http\Requests\EditCustomerBeforeVerification;
use App\Application\Http\Requests\UserLoginRequest;
use App\Application\Http\Requests\UserSingUpRequest;
use App\Application\Http\Resources\CustomerBriefResource;
use App\Application\Http\Resources\CustomerResource;
use App\Domain\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerController extends Controller
{
    private CustomerService $CustomerService;

    public function __construct(CustomerService $CustomerService)
    {
        $this->CustomerService = $CustomerService;
    }

    public function index(): AnonymousResourceCollection
    {
        $customers = $this->CustomerService->getCustomerList();
        return CustomerBriefResource::collection($customers);
    }

    public function show(int $id): CustomerResource
    {
        $customer = $this->CustomerService->getCustomerById($id);
        return new CustomerResource($customer);
    }


    public function updateBeforeVerified(EditCustomerBeforeVerification $request, int $id): CustomerResource
    {
        $validated = $request->validated();
        $customer = $this->CustomerService->updateCustomer($id, $validated);
        return new CustomerResource($customer);

    }

    public function updateAfterVerified(EditCustomerAfterVerification $request, int $id): CustomerResource
    {
        $validated = $request->validated();
        $customer = $this->CustomerService->updateCustomer($id, $validated);
        return new CustomerResource($customer);

    }

    public function userSingUp(UserSingUpRequest $request): JsonResponse
    {
        $data = $this->CustomerService->userSingUp($request->validated());
        return response()->json($data);
    }

    public function userLogin(UserLoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'username', 'password']);
        $data = $this->CustomerService->userLogin($credentials);
        return response()->json($data);
    }

    public function userLogout(): JsonResponse
    {
        $this->CustomerService->userLogout();
        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    public function addCustomerByEmployee(AddCustomerRequest $request): JsonResponse
    {
        $data = $this->CustomerService->userSingUp($request->validated());
        return response()->json($data);
    }

}
