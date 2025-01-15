<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variaveis extends Model
{

    use HasFactory;
    protected $fillable = ['codigo', 'descricao'];

    public function funcionarios()
    {
        return $this->belongsToMany(funcionario::class, 'variaveis_funcionario')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    public function setDescricaoAttribute($value)
    {
        $this->attributes['descricao'] = strtoupper($value);
    }


    
}
