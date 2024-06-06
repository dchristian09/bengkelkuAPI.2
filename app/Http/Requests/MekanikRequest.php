<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MekanikRequest extends FormRequest
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
            'username'=>'required|string|unique:users',
            'password'=>'required',
            'role'=>'required',
            'bengkel_id' => 'required|exists:bengkels,id',
            'mechanic_id' => 'exists:mechanics,id',
            'nama' => 'required|string|max:255',
            'pendapatan' => 'required|numeric|min:0',
        ];
    }
}
