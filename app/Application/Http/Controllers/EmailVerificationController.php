<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\EmailVerificationRequest;
use App\Domain\Models\CD\Customer;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function emailVerification(EmailVerificationRequest $request): JsonResponse
    {
//        $otp2 = $this->otp->validate($request->email, $request->otp);
        $otp2 = $this->otp->validate(Auth::guard('customer')->user()->email, $request->otp);
        if (!$otp2->status) {
            return response()->json([
                'error' => $otp2
            ], 401);
        }

        $customer = Customer::query()->where('email', $request->email)->first();
        $customer->email_verified_at = Carbon::now();
        $customer->save();

        return response()->json([
            'message' => 'Email verified successfully'
        ], 200);
    }

    public function getEmailVerified(): JsonResponse
    {
        //get unique email from otps table
        $uniqueEmails = DB::table('otps')
            ->where('valid', '=', false)
            ->distinct()
            ->pluck('identifier')
            ->toArray();

        return response()->json([
            'emails' => $uniqueEmails
        ]);
    }
}
