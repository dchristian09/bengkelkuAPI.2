<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailTransaksiRequest;
use App\Models\Detail_Transaksi;
use App\Models\Barang;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    public function store(DetailTransaksiRequest $request)
    {
        $validatedData = $request->validated();

        $detailTransaksi = Detail_Transaksi::create($validatedData);

        return response()->json([
            'message' => 'Detail transaksi created successfully',
            'detail_transaksi' => $detailTransaksi
        ], 201);
    }

    public function index(Request $request)
    {
        try {
            $transaksiId = $request->query('transaksi_id');
            
            if ($transaksiId !== null) {
                $detailTransaksi = Detail_Transaksi::where('transaksi_id', $transaksiId)->get();
            } else {
                $detailTransaksi = Detail_Transaksi::all();
            }

            foreach ($detailTransaksi as $dt) {
                $barang = Barang::find($dt->barang_id);
                $dt->nama_barang = $barang ? $barang->nama_barang : null;
                $dt->kode_barang = $barang ? $barang->kode_barang : null;
            }

            return response()->json(['detail_transaksis' => $detailTransaksi], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch detail transaksis'], 500);
        }
    }
    public function update(DetailTransaksiRequest $request, $id)
    {
        try {
            $detailTransaksi = Detail_Transaksi::findOrFail($id);

            $detailTransaksi->update($request->validated());

            return response()->json(['detail_transaksi' => $detailTransaksi, 'message' => 'Detail transaction updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating detail transaction'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $detailTransaksi = Detail_Transaksi::findOrFail($id);
            $detailTransaksi->delete();

            return response()->json(['message' => 'Detail transaksi deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting detail transaksi'], 500);
        }
    }

    public function updateKeuntungan(Request $request, $id)
    {
        try{
            $request->validate([
                'keuntungan_bersih' => 'required|numeric|min:0',
            ]);
    
            $detailTransaksi = Detail_Transaksi::findOrFail($id);
            $detailTransaksi->update(['keuntungan_bersih' => $request->keuntungan_bersih]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating keuntungan bersih'], 500);
        }
    }

    public function getKeuntunganBersih(Request $request, $bengkel_id)
    {
        $date = $request->input('date');

        $transactionIds = Transaction::where('bengkel_id', $bengkel_id)
            ->whereDate('created_at', $date)
            ->pluck('id');

        $netProfit = Detail_Transaksi::whereIn('transaksi_id', $transactionIds)
            ->whereNotNull('keuntungan_bersih')
            ->sum('keuntungan_bersih');

        return response()->json(['net_profit' => $netProfit]);
    }

}
