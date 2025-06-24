<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setor extends Model
{
    use HasFactory;
    protected $table = 'setores';

    protected $fillable = ['nome', 'gestor_id'];

    public function gestor()
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

}
