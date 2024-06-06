<?php

namespace App\Http\Controllers;

use App\Http\Requests\MekanikRequest;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MechanicController extends Controller
{

    public function store(MekanikRequest $request)
    {
        try {
            $validatedData = $request->validated();

            Log::debug('Validated Data:', $validatedData);

            $mechanic = Mechanic::create([
                'nama' => $validatedData['nama'],
                'pendapatan' => $validatedData['pendapatan'],
                'bengkel_id' => $validatedData['bengkel_id'],
            ]);

            $user = User::create([
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']),
                'role' => $validatedData['role'],
                'bengkel_id' => $validatedData['bengkel_id'],
                'mechanic_id' => $mechanic->id
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['user' => $user, 'mechanic' => $mechanic, 'token' => $token], 201);
        } catch (\Exception $e) {
            Log::error('Registration failedt: ' . $e->getMessage());
            return response()->json(['message' => 'Registration failed'], 500);
        }          
    }

    public function index(Request $request)
    {
        try {
            $bengkelId = $request->input('bengkel_id');

            if ($bengkelId !== null) {
                $mechanic = Mechanic::where('bengkel_id', $bengkelId)->get();
            } else {
                $mechanic = Mechanic::all();
            }

            return response()->json(['mechanic' => $mechanic], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch mechanics'], 500);
        }
    }



    public function show($id)
    {
        try {
            $mechanic = Mechanic::findOrFail($id);

            return response()->json(['mechanic' => $mechanic], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Mechanic not found'], 404);
        }
    }

    public function update(MekanikRequest $request, $id)
    {
        try {
            $mechanic = Mechanic::findOrFail($id);

            $mechanic->update($request->validated());

            return response()->json(['mechanic' => $mechanic, 'message' => 'Mechanic updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating mechanic'], 500);
        }
    }

    public function updatePendapatan(Request $request, $id)
    {
        try{
            $request->validate([
                'pendapatan' => 'required|numeric|min:0',
            ]);
    
            $mechanic = Mechanic::findOrFail($id);
            $mechanic->update(['pendapatan' => $request->pendapatan]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating mechanic'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $mechanic = Mechanic::findOrFail($id);
            $mechanic->delete();

            return response()->json(['message' => 'Transaksi deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting transaksi'], 500);
        }
    }

}
