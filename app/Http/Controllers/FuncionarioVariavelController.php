<?php

namespace App\Http\Controllers;

use App\Exports\FuncionarioVariaveisExport;
use App\Models\Funcionario;
use App\Models\FuncionariosVariaveis;
use App\Models\Variaveis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FuncionarioVariavelController extends Controller
{
    public function index()
    {

        return view('variaveis.index');
    }
  

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:funcionarios,id',
            'variable_id' => 'required|exists:variaveis,id',
            'quantity' => 'required',
            'reference_date' => 'required|date',
            'codigo_variavel' => 'required'
        ]);

        // Cria diretamente usando o modelo EmployeeVariable
        FuncionariosVariaveis::create([
            'funcionario_id' => $request->employee_id,
            'variavel_id' => $request->variable_id,
            'quantidade' => $request->quantity,
            'descricao' => $request->descricao,
            'reference_date' => $request->reference_date,
            'codigo_variavel' => $request->codigo_variavel

        ]);

        return redirect()->back()->with('success', 'Variável atribuída com sucesso!');
    }

    public function destroy($id)
    {
        $variable = FuncionariosVariaveis::findOrFail($id);
        $variable->delete();

        return response()->json(['success' => true]);
    }

    public function export(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|between:1,12',
        ]);

        $mes = $request->input('mes');

        return Excel::download(new FuncionarioVariaveisExport($mes), "funcionarios_variaveis_mes_{$mes}.xlsx");
    }
}
