<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Config\Exception\ValidationException;

class Authcontroller extends Controller
{
   public function register(Request $request){
    $validate = $request->validate([
        'name'=>'required|string|max:40',
        'email'=>'requried|email|unique:users,email',
        'pasword'=>'requried|string|min:4|max:15|confirmed',
    ]);

     $user = new User();
     $user->name = $validate['name'];
     $user->usage = $validate['email'];
     $user->password = Hash::make($validate['password']);

     try{
        $user->save();
        return response()->json($user);

     }

     catch (\Exception $exception){
        return response()->json([
            'error'=>'Registration Failed',
            'message'=>$exception->getMessage()
        ]);
     }

   }

   public function login(Request $request){
     $validate = $request->validate([
        'email'=>'requried|email|unique:users,email',
        'pasword'=>'requried|string|min:4|max:15|confirmed',
    ]);

        $user = User::where('email', $validate['email'])->first();

        if(!$user || !Hash::check($validate['password'], $user->password))
        throw ValidationException::withMessage([
        'error'=>'Invalid Credentials'], 401);


         $token = $user->createToken("auth-token")->plainTextToken;

         return response()->json([
            'token'=>"$token",
            'message'=>'login successful',
            'user'=>$user
         ],201);
     }

}    
