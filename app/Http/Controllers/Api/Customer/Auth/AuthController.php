<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Models\User;
use App\Jobs\SendOTPEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Api\Customer\LoginRequest;
use App\Http\Requests\Api\Customer\VerifyRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        //search on phone in database
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        //if $user generate OTP
        $otp = $this->generateOTPCode($user);

        // dispatch the job to the queue
        SendOTPEmail::dispatch($user, $otp);
        //return OTP
        return response()->json([
            'OTP' => $otp,
            'message' => 'OTP sent successfully',
            'status' => '200'

        ]);
    }

    public function verify(VerifyRequest $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        //get user from cache
        $cached_otp = Cache::get("otp_{$user->email}");

        if (!$cached_otp || $cached_otp != $request->otp) {
            return response()->json([
                'message' => 'Invalid OTP',
                'status' => '400'
            ], 400);
        }
        Cache::forget("otp_{$user->email}");
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'customer' => $user,
            'message' => 'Login successful',
            'status' => '200'
        ]);
    }

    public function logout()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 200
        ], 200);
    }
    private function generateOTPCode($user)
    {
        $otp = rand(100000, 999999);
        Cache::put("otp_{$user->email}", $otp, now()->addMinutes(5));
        return $otp;
    }
}
