<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateIdDplRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function messages(): array{
        return [
            'required' => 'wajib diisi',
            'string' => 'wajib dalam bentuk kata',
            'numeric' => 'wajib dalam bentuk angka'
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
            'nim' => 'required|numeric',
            'prodi' => 'required|string',
            'id_dpl' => 'required|numeric'
        ];
    }
}
