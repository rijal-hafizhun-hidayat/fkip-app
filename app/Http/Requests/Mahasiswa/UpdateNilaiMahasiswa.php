<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateNilaiMahasiswa extends FormRequest
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
            'numeric' => 'wajib dalam bentuk angka',
            'string' => 'wajib dalam bentuk teks',
            'min_digits' => 'minimal 10 angka',
            'max_digits' => 'maximal 10 angka'
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
            'nilai_kompeten' => 'required|array',
            'nilai_kompeten.*' => 'required|numeric'
        ];
    }
}
