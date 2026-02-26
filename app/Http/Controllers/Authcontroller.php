<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\verifyemailnotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class Authcontroller extends Controller
{
   public function register(Request $request)
   {
      $validated= $request->validate([
         'name' => 'required|string|max:40',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|string|min:4|max:15|confirmed',
         'user_image' => 'nullable|image|max:255|mimes:jpeg,jpg,png',
         'is_active' => 'nullable|boolean',
         'role_id' =>'required|integer|exists:roles,id',

      ]);
      if ($request->role_id) {
         $role_id = $request->role_id;
      } else {
         $role = Role::where('name', 'user')->first();
         $role_id = $role->id;
      }

      $role = Role::where('name', 'User')->first();

      $user = new User();
      $user->name = $validated['name'];
      $user->email = $validated['email'];
      $user->role_id = $validated['role_id'];
      $user->password = Hash::make($validated['password']);

      if ($request->hasFile('user_image')) {
         $filename = $request->file('user_image')->store('user_images', 'public');
       
      } else{
         $filename=null;
      } 
        $user->user_image = $filename;

      try {
         $user->save();
         $signedUrl = URL::temporarySignedroute(
            'verification.verify',
            now()->addMinutes(60),
            [
               'id' => $user->id,
               'hash' => sha1($user->email)
            ]
         );

         $user->notify(new verifyemailnotification($signedUrl));

         return response()->json([
            'message' => 'Verification Email resent successfully.'
         ], 200);
         return response()->json($user);
      } catch (\Exception $exception) {
         return response()->json([
            'error' => 'Registration Failed',
            'message' => $exception->getMessage()
         ]);
      }
   }

   public function login(Request $request)
   {
      $validate = $request->validate([
         'email' => 'required|email',
         'password' => 'required|string|min:4|max:15',
      ]);

      $user = User::where('email', $validate['email'])->first();

      if (! $user || ! Hash::check($validate['password'], $user->password)) {
         throw ValidationException::withMessages([
            'error' => ['Invalid Credentials'],
         ], 401);
      }

      if (!$user->is_active) {
         return response()->json([
            'message' => 'Your account is not active. Please Verify your Email address'
         ], 403);
      }


      $token = $user->createToken("auth-token")->plainTextToken;

      return response()->json([
         'message' => 'login successful',
         'token' => $token,
         'user' => $user,
         'abilities' => $user->abilities()
      ], 201);
   }

   public function logout(Request $request)
   {
      $request->user()->currentAccessToken()->delete();
      return response()->json('Logout Successfull.');
   }

   
}
