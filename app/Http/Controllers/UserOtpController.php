<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\userOtp;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class UserOtpController extends Controller
{
  public function verifyOtp(Request $request){
    $request->validate([
        'email'=>'required|email',
        'otp'=>'required|string',
    ]);

    $user = User::where('email',$request->email)->first();


    if (!$user){
         return response()->json([
            'message'=>'user not found'
        ],404);
       }

       $otpEntry = userOtp::where('user_id',$user->id)
                           ->where('otp',$request->otp)
                           ->first();
        if(!$otpEntry || $otpEntry->isExpired()){
            return response()->json([
                'message'=>'Expired otp or Invalid OTP'
            ],400);
        }

        $otpEntry->delete();
        $user->tokens()->delete();

        $token = $user->createToken('new-token')->plainTextToken;

        return response()->json([
            'message'=> 'Login Successful',
            'token'=>$token,
            'user'=>$user
        ],201);
    }
}
