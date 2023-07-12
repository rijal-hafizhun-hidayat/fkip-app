<?php

namespace App\Http\Requests\Akun;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAkunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function messages(): array
    {
        return [
            'required' => 'Wajib diisi',
            'string' => 'Wajib dalam bentuk teks',
            'numeric' => 'Wajib dalam bentuk angka',
            'email' => 'Wajib format email'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string',
            'role' => 'required|numeric',
            'id_dpl' => 'nullable|numeric',
            'id_guru_pamong' => 'nullable|numeric'
        ];
    }
}
