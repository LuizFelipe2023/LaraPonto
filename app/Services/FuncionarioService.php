<?php

namespace App\Services;

use App\Models\Funcionario;
use Exception;

class FuncionarioService
{
    public function getFuncionarioById($id)
    {
        return Funcionario::findOrFail($id);
    }

    public function getAllFuncionarios()
    {
        $user = auth()->user();

        if ($user->tipo_usuario == 1) {
            return Funcionario::with('setor')->get();
        }

        if ($user->tipo_usuario == 2) {
            $setoresIds = $user->setoresGerenciados->pluck('id')->toArray();

            return Funcionario::with('setor')
                ->whereIn('setor_id', $setoresIds)
                ->get();
        }

        abort(403, 'Acesso não autorizado.');
    }

    public function insertFuncionario(array $data)
    {
        return Funcionario::create([
            'user_id' => $data['user_id'],
            'setor_id' => $data['setor_id'],
            'cargo' => $data['cargo'],
            'salario' => $data['salario'],
            'data_admissao' => $data['data_admissao'],
            'data_desligamento' => $data['data_desligamento'] ?? null,
            'status_id' => $data['status_id']
        ]);
    }

    public function updateFuncionario($id, array $data)
    {
        $funcionario = $this->getFuncionarioById($id);

        $funcionario->update([
            'user_id' => $data['user_id'],
            'setor_id' => $data['setor_id'],
            'cargo' => $data['cargo'],
            'salario' => $data['salario'],
            'data_admissao' => $data['data_admissao'],
            'data_desligamento' => $data['data_desligamento'] ?? null,
            'status_id' => $data['status_id']
        ]);

        return $funcionario;
    }

    public function deleteFuncionario($id)
    {
        $funcionario = $this->getFuncionarioById($id);
        return $funcionario->delete();
    }

    public function getPontosByFuncionario(int $funcionarioId)
    {
        $funcionario = $this->getFuncionarioById($funcionarioId);
        return $funcionario->pontos()->orderBy('data', 'desc')->orderBy('hora_entrada', 'desc')->get();
    }

    public function feriasFuncionario($id)
    {
           return Funcionario::with(['ferias'])->findOrFail($id);
    }

}
