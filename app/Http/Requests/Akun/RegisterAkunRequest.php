<?php

namespace App\Http\Requests\Akun;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAkunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'password' => 'required|string',
            'email' => 'nullable|email:rfc,dns',
            'nim' => 'sometimes|required|numeric',
            'niy' => 'sometimes|required|numeric',
            'role' => 'required|numeric',
            'id_guru_pamong' => 'nullable|numeric',
            'id_mahasiswa' => 'nullable|numeric'
        ];
    }
}
