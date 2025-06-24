<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusFuncionario extends Model
{
    use HasFactory;

    protected $table = 'status_funcionarios';

    protected $fillable = ['nome', 'descricao'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'status_id');
    }
}
