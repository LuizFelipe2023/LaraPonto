<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertAtrasoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->tipo_usuario, [1, 2]);
    }

    public function rules(): array
    {
        return [
            'funcionario_id' => ['required', 'exists:funcionarios,id'],
            'data'           => ['required', 'date'],
            'tempo_atraso'   => ['required', 'string', 'max:30'], 
            'motivo'         => ['nullable', 'string', 'max:255'],
            'justificado'    => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'funcionario_id.required' => 'O funcionário é obrigatório.',
            'funcionario_id.exists'   => 'O funcionário selecionado não existe.',
            'data.required'           => 'A data do atraso é obrigatória.',
            'data.date'               => 'A data deve ser um valor válido.',
            'tempo_atraso.required'   => 'O tempo de atraso é obrigatório.',
            'tempo_atraso.string'     => 'O tempo de atraso deve ser um texto.',
            'motivo.string'           => 'O motivo deve ser um texto.',
            'justificado.required'    => 'O campo "justificado" é obrigatório.',
            'justificado.boolean'     => 'O campo "justificado" deve ser verdadeiro ou falso.',
        ];
    }
}
