<?php

namespace App\Services;

use App\Models\StatusFuncionario;
use Exception;

class StatusFuncionarioService
{
    public function getAllStatuses()
    {
        return StatusFuncionario::orderBy('nome')->get();
    }

    public function getStatusById($id)
    {
        return StatusFuncionario::findOrFail($id);
    }

    public function insertStatus(array $data)
    {
        return StatusFuncionario::create([
            'nome'      => $data['nome'],
            'descricao' => $data['descricao']
        ]);
    }

    public function updateStatus($id, array $data)
    {
        $status = $this->getStatusById($id);

        $status->update([
            'nome'      => $data['nome'],
            'descricao' => $data['descricao']
        ]);

        return $status;
    }

    public function deleteStatus($id)
    {
        $status = $this->getStatusById($id);
        return $status->delete();
    }
}
