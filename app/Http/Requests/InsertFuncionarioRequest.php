<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertFuncionarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permite o envio do formulário
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'           => 'required|exists:users,id',
            'setor_id'          => 'nullable|exists:setores,id',
            'cargo'             => 'required|string|max:255',
            'salario'           => 'required|numeric|min:0',
            'data_admissao'     => 'required|date',
            'data_desligamento' => 'nullable|date|after_or_equal:data_admissao',
            'status_id'         => 'required|exists:status_funcionarios,id'
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.exists' => 'O usuário selecionado é inválido.',
            
            'setor_id.exists' => 'O setor selecionado é inválido.',

            'cargo.required' => 'O campo cargo é obrigatório.',
            'cargo.string' => 'O campo cargo deve ser um texto.',
            'cargo.max' => 'O campo cargo deve ter no máximo 255 caracteres.',

            'salario.required' => 'O campo salário é obrigatório.',
            'salario.numeric' => 'O campo salário deve ser numérico.',
            'salario.min' => 'O salário deve ser no mínimo 0.',

            'data_admissao.required' => 'A data de admissão é obrigatória.',
            'data_admissao.date' => 'Informe uma data de admissão válida.',

            'data_desligamento.date' => 'Informe uma data de desligamento válida.',
            'data_desligamento.after_or_equal' => 'A data de desligamento deve ser igual ou posterior à data de admissão.',

            'status_id.required' => 'O campo status é obrigatório.',
            'status_id.exists' => 'O status selecionado é inválido.',
        ];
    }
}
