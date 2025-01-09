<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Variable;
use App\Models\EmployeeVariable;
use App\Models\Funcionario;
use App\Models\FuncionariosVariaveis;
use App\Models\Variaveis;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function searchEmployees(Request $request)
    {
        $search = $request->input('search');

        return Funcionario::where('nome', 'LIKE', "%{$search}%")
            ->orWhere('matricula', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get();
    }

    public function searchVariables(Request $request)
    {
        $search = $request->input('search');

        return Variaveis::where('codigo', 'LIKE', "%{$search}%")
            ->orWhere('descricao', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get();
    }

    public function getEmployeeVariables($funcionario_id)
    {
        return FuncionariosVariaveis::with(['funcionario', 'variavel'])
            ->where('funcionario_id', $funcionario_id)
            ->get();
    }
}
