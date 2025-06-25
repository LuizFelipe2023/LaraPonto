<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends FormRequest
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
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.required'  => 'Por favor, informe sua senha atual.',
            'new_password.required'      => 'Por favor, informe a nova senha.',
            'new_password.string'        => 'A nova senha deve ser uma sequência de caracteres válida.',
            'new_password.min'           => 'A nova senha deve ter no mínimo :min caracteres.',
            'new_password.confirmed'     => 'A confirmação da nova senha não confere.',
        ];
    }
}
