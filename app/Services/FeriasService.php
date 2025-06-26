<?php

namespace App\Services;
use App\Models\Ferias;

class FeriasService
{
    public function getAllFerias()
    {
        $user = auth()->user();

        $query = Ferias::select('ferias.*')
            ->join('funcionarios', 'funcionarios.id', '=', 'ferias.funcionario_id')
            ->join('setores', 'setores.id', '=', 'funcionarios.setor_id')
            ->with(['funcionario.setor'])
            ->orderBy('setores.nome');

        if ($user->tipo_usuario == 2) {
            $query->where('funcionarios.setor_id', $user->setor_id);
        } elseif ($user->tipo_usuario == 3) {
            return collect(); 
        }

        return $query->get();
    }

    public function getFeriasById($id)
    {
           return Ferias::findOrFail($id);
    }

    public function insertFerias(array $data)
    {
           return Ferias::create($data);
    }

    public function updateFerias($id, array $data)
    {
           $ferias = $this->getFeriasById($id);
           $ferias->update($data);
           return $ferias;
    }

    public function destroyFerias($id)
    {
           $ferias = $this->getFeriasById($id);
           return $ferias->delete();
    }


}