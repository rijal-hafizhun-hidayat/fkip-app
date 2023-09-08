<?php

namespace App\Http\Requests\Akun;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAkunRequest extends FormRequest
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
            'numeric' => 'Error',
            'email' => 'Format Email Salah'
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
            'nama_depan' => 'required|string',
            'nama' => 'required|string',
            'username' => 'required|string',
            'email' => 'nullable|email:rfc,dns',
            'role' => 'required|numeric',
            'id_dpl' => 'nullable|numeric',
            'id_guru_pamong' => 'nullable|numeric',
            'id_mahasiswa' => 'nullable|numeric'
        ];
    }
}
