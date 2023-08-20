<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\ForgetPasswordRequest;
use App\Domain\Models\CD\Customer;
use App\Notifications\ResetPasswordVerificationNotification;
use Illuminate\Http\JsonResponse;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $input = $request->only('email');
        $customer = Customer::query()->where('email', $input)->first();
        $customer->notify(new ResetPasswordVerificationNotification());

        return response()->json([
            'message' => 'User Receive email Successfully'
        ]);
    }
}
