<?php

namespace App\Http\Requests\Bimbingan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBimbinganRequest extends FormRequest
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
            'string' => 'wajib dalam bentuk kalimat',
            'url' => 'wajib link yang valid'
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
            'keterangan_bimbingan' => 'required|string',
            'link' => 'required|url:https',
            'tahap_bimbingan' => 'required|string'
        ];
    }
}
