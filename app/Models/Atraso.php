<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atraso extends Model
{
    use HasFactory;

    protected $table = 'atrasos';

    protected $fillable = [
        'funcionario_id',
        'data',
        'tempo_atraso',
        'motivo',
        'justificado',
    ];

    protected $casts = [
        'data' => 'date',
        'justificado' => 'boolean',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
