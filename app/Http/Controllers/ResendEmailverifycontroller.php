<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\verifyemailnotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ResendEmailverifycontroller extends Controller
{
  public function resend(Request $request) {
    $request->validate([
        'email'=>'required|email'
    ]);
    $user = User::where('email', $request->email)->first();

      if(!$user){
        return response()->json([
            'message'=>'user not found'
        ], 404);

      }

      if ( $user->hasverifiedemail()){
        return Response()->json([
            'message'=>'Email is already verifyed'
        ], 200);
      } 
       
      $signedUrl = URL::temporarySignedroute( 
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' =>$user->id,
            'hash'=>sha1($user->email)
        ]        
      );

      $user->notify(new verifyemailnotification($signedUrl));

      return response()->json([
        'message'=>'Verification Email resent successfully.'
      ],200);
  }
}
