<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Falta extends Model
{
    use HasFactory;

    protected $table = 'faltas';

    protected $fillable = [
        'funcionario_id',
        'data',
        'motivo',
        'tipo',
        'aprovado',
    ];

    protected $casts = [
        'data' => 'date',
        'aprovado' => 'boolean',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
