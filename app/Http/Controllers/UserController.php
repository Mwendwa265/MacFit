<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // when using blade
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'phoneNumber'=>'nullable|string',
            'gender'=>'nullable|string',
            'dateOfBirth'=>'nullable|string',
            'gymLocation'=>'nullable|string',
            'role_id'=>'required|integer|exists:roles,id',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make('Qwerty1234');
        $user->role_id = $validated['role_id'];
        $user->phoneNumber = $validated['phoneNumber'];
        $user->gender = $validated['gender'];
        $user->dateOfBirth = $validated['dateOfBirth'];
        $user->gymLocation = $validated['gymLocation'];
        $user->is_active = true; //to delete later after email verification

        $user->save();

        return response()->json(['message' => 'Role Saved Successfully.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
