<?php

namespace App\Http\Requests\Dpl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDplRequest extends FormRequest
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
            'required' => 'wajib diisi',
            'numeric' => 'wajib dalam bentuk angka',
            'string' => 'wajib dalam bentuk teks',
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
            'nipy' => 'required|numeric',
            'nama' => 'required|string',
            'prodi' => 'required|string'
        ];
    }
}
