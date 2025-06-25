<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
      protected $table = 'pontos';

      protected $fillable = ['funcionario_id','data','hora_entrada','hora_saida'];


      public function funcionario()
      {
             return $this->belongsTo(Funcionario::class,'funcionario_id');
      }
}
