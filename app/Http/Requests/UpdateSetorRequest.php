<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Altere para `true` se quiser permitir a requisição.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Supondo que seja semelhante ao InsertSetorRequest:
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'gestor_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Mensagens personalizadas para os erros.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O nome deve ser uma sequência de caracteres.',
            'nome.max' => 'O nome não pode ultrapassar 255 caracteres.',

            'gestor_id.required' => 'O campo gestor é obrigatório.',
            'gestor_id.exists' => 'O gestor selecionado não é válido.',
        ];
    }
}
