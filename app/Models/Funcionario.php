<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'matricula', 'secao', 'diretoria', 'cargo'];



    public function variaveis()
    {
        return $this->belongsToMany(Variaveis::class, 'variaveis_funcionario')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }

    // Convertendo o campo 'cargo' para maiúsculo
    public function setCargoAttribute($value)
    {
        $this->attributes['cargo'] = strtoupper($value);
    }

    // Convertendo o campo 'diretoria' para maiúsculo
    public function setDiretoriaAttribute($value)
    {
        $this->attributes['diretoria'] = strtoupper($value);
    }

    // Convertendo o campo 'secao' para maiúsculo
    public function setSecaoAttribute($value)
    {
        $this->attributes['secao'] = strtoupper($value);
    }

    
}
