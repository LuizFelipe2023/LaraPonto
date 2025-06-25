<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarSaidaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hora_saida' => 'required|date_format:H:i:s'
        ];
    }

    public function messages(): array
    {
        return [
            'hora_saida.required' => 'O horário de saída é obrigatório.',
            'hora_saida.date_format' => 'O horário de saída deve estar no formato HH:MM:SS.'
        ];
    }
}

