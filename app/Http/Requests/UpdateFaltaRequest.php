<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaltaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->tipo_usuario, [1, 2]);
    }

    public function rules(): array
    {
        return [
            'data'        => ['sometimes', 'required', 'date'],
            'motivo'      => ['nullable', 'string', 'max:255'],
            'justificado' => ['sometimes', 'required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.required'        => 'A data da falta é obrigatória.',
            'data.date'            => 'Informe uma data válida.',
            'motivo.string'        => 'O motivo deve ser um texto.',
            'motivo.max'           => 'O motivo não pode exceder 255 caracteres.',
            'justificado.required' => 'Informe se a falta foi justificada.',
            'justificado.boolean'  => 'O valor de justificado deve ser verdadeiro ou falso.',
        ];
    }
}

