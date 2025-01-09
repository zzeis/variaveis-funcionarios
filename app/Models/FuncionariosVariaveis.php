<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuncionariosVariaveis extends Model
{
    use SoftDeletes;
    protected $table = 'variaveis_funcionario';
    protected $fillable = [
        'funcionario_id',
        'variavel_id',
        'quantidade',
        'codigo_variavel',
        'reference_date'
    ];

    protected $casts = [
        
        
        'deleted_at' => 'datetime'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function variavel()
    {
        return $this->belongsTo(Variaveis::class);
    }
}