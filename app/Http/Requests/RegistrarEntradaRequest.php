<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarEntradaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i:s'
        ];
    }

    public function messages(): array
    {
        return [
            'funcionario_id.required' => 'O funcionário é obrigatório.',
            'funcionario_id.exists' => 'O funcionário selecionado não existe.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser válida.',
            'hora_entrada.required' => 'O horário de entrada é obrigatório.',
            'hora_entrada.date_format' => 'O horário de entrada deve estar no formato HH:MM:SS.'
        ];
    }
}
