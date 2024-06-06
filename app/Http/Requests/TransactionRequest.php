<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'plat_nomor' => 'required|string|max:255',
            'harga_jasa' => 'nullable|numeric|min:0',
            'total_transaksi' => 'required|numeric|min:0',
            'status_transaksi' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'mechanic_id' => 'required|exists:mechanics,id',
            'bengkel_id' => 'required|exists:bengkels,id',
        ];
    }
}
