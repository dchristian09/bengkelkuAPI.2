<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bengkel;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $bengkel = Bengkel::create([
                'nama_bengkel' => $validatedData['nama_bengkel'],
                'alamat' => $validatedData['alamat'],
                'pendapatan' => 0,
            ]);

            $user = User::create([
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']),
                'role' => $validatedData['role'],
                'bengkel_id' => $bengkel->id,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['user' => $user, 'bengkel' => $bengkel, 'token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }

    public function login (LoginRequest $request)
    {
        $request->validated();
        
        $user = User::whereUsername($request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message'=>'Invalid credentials'
            ], 422);
        }

        $token = $user->createToken('bengkelku')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);

    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required',
            'role' => 'required',
            'bengkel_id' => 'required'
        ]);

        if(User::where('username', $validatedData['username'])->exists()) {
            return response()->json(['message' => 'Username already exists'], 422);
        }

        $user = User::create([
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'bengkel_id' => $validatedData['bengkel_id'],
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user 
        ], 201);
    }

}
