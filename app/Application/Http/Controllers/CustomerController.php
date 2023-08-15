<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\AddCustomerRequest;
use App\Application\Http\Requests\EditCustomerAfterVerification;
use App\Application\Http\Requests\EditCustomerBeforeVerification;
use App\Application\Http\Requests\UserLoginRequest;
use App\Application\Http\Requests\UserSingUpRequest;
use App\Application\Http\Resources\CustomerBriefResource;
use App\Application\Http\Resources\CustomerResource;
use App\Application\Http\Resources\CustomersMissedAppointments;
use App\Domain\Services\CustomerService;
use App\Utils\StorageUtilities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

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


//    public function updateBeforeVerified(EditCustomerBeforeVerification $request, int $id): CustomerResource
//    {
//        $validated = $request->validated();
//        $customer = $this->CustomerService->updateCustomer($id, $validated);
//        return new CustomerResource($customer);
//
//    }

    public function update(EditCustomerAfterVerification $request, int $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = StorageUtilities::storeCustomerPhoto($data['profile_picture']);
        }

        $customer = $this->CustomerService->updateCustomer($id, $data);
        return response()->json([
            'data'=> new CustomerResource($customer)
        ], 200);

    }

    public function destroy(int $id): JsonResponse
    {
        $customer = $this->CustomerService->deleteCustomer($id);

        return response()->json([
            'data'=> new CustomerResource($customer)
        ], 200);

    }

//    public function userSingUp(UserSingUpRequest $request): JsonResponse
//    {
//        $data = $request->validated();
//
//        if ($request->hasFile('profile_picture')) {
//            $data['profile_picture'] = StorageUtilities::storeCustomerPhoto($request['profile_picture']);
//        }
//
//        $data = $this->CustomerService->userSingUp($data);
//        return response()->json([
//            'token' => $data['token'],
//            'data'=> new CustomerResource($data['customer_data'])
//        ], 200);
//    }

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
        $data = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = StorageUtilities::storeCustomerPhoto($request['profile_picture']);
        }

        $data = $this->CustomerService->userSingUp($data);
        return response()->json([
            'token' => $data['token'],
            'data'=> new CustomerResource($data['customer_data'])
        ], 200);
    }


    public function customersMissedAppointments(): AnonymousResourceCollection
    {
        $data = $this->CustomerService->customersMissedAppointments();
        return CustomersMissedAppointments::collection($data);
    }

    public function customerToggleStatus(int $id): JsonResponse
    {
        $customer = $this->CustomerService->customerToggleStatus($id);
        return response()->json([
            'data'=> new CustomerResource($customer)
        ], 200);
    }

    public function customerDetection(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'national_number' => [
                'required',
                'integer',
                'digits:11'
            ],
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors'=> $errors
            ], 400);
        }
        $data = request()->all();
        $customerStatus = $this->CustomerService->customerDetection($data['national_number']);
        return response()->json([
            'data' => $customerStatus
        ], 200);
    }



}
