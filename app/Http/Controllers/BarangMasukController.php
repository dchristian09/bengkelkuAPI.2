<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangMasukRequest;
use App\Models\Barang_Masuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function store(BarangMasukRequest $request)
    {
        $validatedData = $request->validated();

        $barangMasuk = Barang_Masuk::create($validatedData);

        return response()->json([
            $barangMasuk
        ], 201);
    }

    public function index($barang_id)
    {
        try {
            $barangMasukList = Barang_Masuk::where('barang_id', $barang_id)->get();

            return response()->json(['barang_masuk' => $barangMasukList], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching barang_masuk'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kuantitas_barang' => 'required|integer|min:1',
                'harga_modal' => 'required|numeric|min:0',
            ]);

            $barangMasuk = Barang_Masuk::findOrFail($id);
            $barangMasuk->update([
                'kuantitas_barang' => $request->kuantitas_barang,
                'harga_modal' => $request->harga_modal,
            ]);

            return response()->json(['message' => 'Barang Masuk updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating Barang Masuk'], 500);
        }
    }


    public function delete($id)
    {
        try {
            $barangMasuk = Barang_Masuk::findOrFail($id);
            $barangMasuk->delete();

            return response()->json(['message' => 'Barang masuk deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting barang masuk'], 500);
        }
    }

    public function reduceStock($barangMasukId, Request $request)
    {
        try {
            $barangMasuk = Barang_Masuk::findOrFail($barangMasukId);

            $requestedQuantity = $request->input('quantity');
            $remainingStock = $barangMasuk->kuantitas_barang - $requestedQuantity;
            $barangMasuk->update(['kuantitas_barang' => max(0, $remainingStock)]);

            return response()->json(['message' => 'Stock reduced successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to reduce stock'], 500);
        }
    }
}
