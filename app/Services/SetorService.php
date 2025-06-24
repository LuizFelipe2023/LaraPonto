<?php

namespace App\Services;
use App\Models\Setor;

class SetorService
{
      public function index()
      {
             return Setor::orderBy('nome')->get();
      }

      public function getSetorById($id)
      {
             return Setor::findOrFail($id);
      }

      public function insertSetor(array $data)
      {
             return Setor::create([
                  'nome' => $data['nome'],
                  'gestor_id' => $data['gestor_id']
             ]);
      }

      public function updateSetor($id, array $data)
      {
             $setor = $this->getSetorById($id);
             $setor->update([
                 'nome' => $data['nome'],
                 'gestor_id' => $data['gestor_id']
             ]);
             return $setor;
      }

      public function destroySetor($id)
      {
             $setor = $this->getSetorById($id);
             return $setor->delete();
      }
}