<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        $validatedData = $request->validated();

        $transaction = Transaction::create($validatedData);

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction
        ], 201);
    }

    public function index(Request $request)
    {
        try {
            $date = $request->input('date');
            $bengkelId = $request->input('bengkel_id');

            if ($date !== null && $bengkelId !== null) {
                $transactions = Transaction::whereDate('created_at', $date)->where('bengkel_id', $bengkelId)->get();
            } elseif ($date !== null) {
                $transactions = Transaction::whereDate('created_at', $date)->get();
            } elseif ($bengkelId !== null) {
                $transactions = Transaction::where('bengkel_id', $bengkelId)->get();
            } else {
                $transactions = Transaction::all();
            }

            return response()->json(['transactions' => $transactions], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch transactions'], 500);
        }
    }



    public function show($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            return response()->json(['transaction' => $transaction], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }

    public function update(TransactionRequest $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            $transaction->update($request->validated());

            return response()->json(['transaction' => $transaction, 'message' => 'Transaction updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating transaction'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return response()->json(['message' => 'Transaksi deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting transaksi'], 500);
        }
    }

    public function dataTransaksiMekanik(Request $request)
    {
        try {
            $date = $request->input('date');
            $mechanicId = $request->input('mechanic_id');

            if ($date !== null && $mechanicId !== null) {
                $transactions = Transaction::whereDate('created_at', $date)->where('mechanic_id', $mechanicId)->get();
            } elseif ($date !== null) {
                $transactions = Transaction::whereDate('created_at', $date)->get();
            } elseif ($mechanicId !== null) {
                $transactions = Transaction::where('mechanic_id', $mechanicId)->get();
            } else {
                $transactions = Transaction::all();
            }

            return response()->json(['transactions' => $transactions], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch transactions'], 500);
        }
    }

}
