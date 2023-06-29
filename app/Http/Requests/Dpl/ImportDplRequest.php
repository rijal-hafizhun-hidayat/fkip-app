<?php

namespace App\Http\Requests\Dpl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportDplRequest extends FormRequest
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
            'file' => 'wajib dalam bentuk file',
            'mimes' => 'wajib dalam bentuk excel'
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
            'excel' => 'required|file|mimes:xlsx, xls'
        ];
    }
}
