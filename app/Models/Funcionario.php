<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = ['nome', 'matricula', 'secao', 'diretoria', 'cargo'];



    public function variaveis()
    {
        return $this->belongsToMany(Variaveis::class, 'variaveis_funcionario')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    use HasFactory;
}
