<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;
use App\Http\Requests\BengkelRequest;

class BengkelController extends Controller
{
    public function store(BengkelRequest $request)
    {
        $validatedData = $request->validated();

        $bengkel = Bengkel::create($validatedData);

        return response()->json([
            'message' => 'Bengkel created successfully',
            'bengkel' => $bengkel
        ], 201);
    }

    public function show($id)
    {
        try {
            $bengkel = Bengkel::findOrFail($id);

            return response()->json(['bengkel' => $bengkel], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bengkel not found'], 404);
        }
    }
    public function update(BengkelRequest $request, $id)
    {
        try {
            $bengkel = Bengkel::findOrFail($id);

            $bengkel->update($request->validated());

            return response()->json(['bengkel' => $bengkel, 'message' => 'Barang updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating bengkel'], 500);
        }
    }
}
