<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class verifyemailcontroller extends Controller
{
  public function verify(Request $request, $id , $hash) {
    $user = User::where('id', $id)->first();

    if(!hash_equals((string) $hash , sha1($user->email))){
        return response()->json([
            'message'=>'invalid verification link.'
        ], 403);
    }

    if($user->hasVerifiedEmail()){
        return response()->json([
            'message'=>'Email is Already Verified.'
        ], 200);
    }

    $signedUrl = URL::temporarySignedroute(
            'verification.verify',
            now()->addMinutes(60),
            [
               'id' => $user->id,
               'hash' => sha1($user->email)
            ]);


    $user->markEmailasVerified();
    event(new Verified($user));

    $user->is_active = 1;
    $user->save();
    return response()->json( "Email Verified Successfully!");
    
  }
}
