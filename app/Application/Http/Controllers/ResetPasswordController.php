<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\ResetPasswordRequest;
use App\Domain\Models\CD\Customer;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function passwordReset(ResetPasswordRequest $request): JsonResponse
    {
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return \response()->json([
                'error' => $otp2
            ], 401);
        }
        $customer = Customer::query()->where('email', $request->email)->first();
//        $customer = Customer::query()->where('email', Auth::guard('customer')->user()->email)->first();
        $customer->update([
            'password' => Hash::make($request->password)
        ]);
        $customer->tokens()->delete();
        return response()->json([
            'message' => 'Password reset successfully'
        ]);
    }
}
