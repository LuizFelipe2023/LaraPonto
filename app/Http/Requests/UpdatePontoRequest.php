<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePontoRequest extends FormRequest
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
            'hora_entrada' => 'required|date_format:H:i',
            'hora_saida' => 'required|date_format:H:i',
        ];
    }

    public function messages(): array
    {
        return [
            'funcionario_id.required' => 'O campo funcionário é obrigatório.',
            'funcionario_id.exists' => 'O funcionário selecionado não existe.',

            'data.required' => 'O campo data é obrigatório.',
            'data.date' => 'O campo data deve ser uma data válida.',

            'hora_entrada.required' => 'O campo hora de entrada é obrigatório.',
            'hora_entrada.date_format' => 'O campo hora de entrada deve estar no formato HH:mm.',

            'hora_saida.required' => 'O campo hora de saída é obrigatório.',
            'hora_saida.date_format' => 'O campo hora de saída deve estar no formato HH:mm.',
        ];
    }
}
