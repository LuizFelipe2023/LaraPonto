<?php

namespace App\Services;
use App\Models\TipoUsuario;

class TipoUsuarioService
{
      public function getAllTipoUsuarios()
      {
             return TipoUsuario::all();
      }

      public function getTipoUsuario($id):TipoUsuario
      {
             return TipoUsuario::findOrFail($id);
      }
      
}