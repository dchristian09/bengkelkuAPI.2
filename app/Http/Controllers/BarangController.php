<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function store(BarangRequest $request)
    {
        $validatedData = $request->validated();

        $existingBarang = Barang::where('nama_barang', $validatedData['nama_barang'])
                                ->where('bengkel_id', $validatedData['bengkel_id'])
                                ->first();

        if ($existingBarang) {
            return response()->json([
                'error' => 'Barang from this bengkel already exist.'
            ], 422);
        }

        $barang = Barang::create($validatedData);

        return response()->json([
            'message' => 'Barang created successfully',
            'barang' => $barang 
        ], 201);
    }


    public function index(Request $request)
    {
        try {
            $bengkelId = $request->input('bengkel_id');

            if ($bengkelId !== null) {
                $barangs = Barang::where('bengkel_id', $bengkelId)->get();
            } else {
                $barangs = Barang::all();
            }

            return response()->json(['barangs' => $barangs], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch barang'], 500);
        }
    }


    public function show($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            return response()->json(['barang' => $barang], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Barang not found'], 404);
        }
    }

    public function update(BarangRequest $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $validatedData = $request->validated();

            $existingBarang = Barang::where('nama_barang', $validatedData['nama_barang'])
                                    ->where('bengkel_id', $barang->bengkel_id)
                                    ->where('id', '!=', $id)
                                    ->first();

            if ($existingBarang) {
                return response()->json([
                    'error' => 'Barang from this bengkel already exist.'
                ], 422);
            }

            $barang->update($validatedData);

            return response()->json(['barang' => $barang, 'message' => 'Barang updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating barang'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();

            return response()->json(['message' => 'Barang deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting barang'], 500);
        }
    }
}
