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
            'matricula' => 'required|exists:funcionarios,matricula',
            'variable_id' => 'required|exists:variaveis,id',
            'quantity' => 'required',
            'reference_date' => 'required|date',
            'codigo_variavel' => 'required'
        ]);

        $funcionario = Funcionario::where('matricula', $request->matricula)->first();

        FuncionariosVariaveis::create([
            'funcionario_id' => $funcionario->id,
            'matricula' => $request->matricula, // Armazenamos a matrícula também
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

    public function syncFuncionarioVariaveis()
    {
        // Obter todos os funcionários atuais com suas matrículas
        $funcionariosAtuais = Funcionario::pluck('id', 'matricula')->toArray();

        // Obter registros de variáveis
        $registros = FuncionariosVariaveis::all();

        $atualizados = 0;
        $semMatricula = [];

        foreach ($registros as $registro) {
            // Se já temos a matrícula armazenada
            if ($registro->matricula) {
                // Verificar se existe funcionário com essa matrícula
                if (array_key_exists($registro->matricula, $funcionariosAtuais)) {
                    // Atualizar para o novo ID
                    $registro->funcionario_id = $funcionariosAtuais[$registro->matricula];
                    $registro->save();
                    $atualizados++;
                }
            } else {
                // Não temos a matrícula - precisamos tratar esse caso
                $semMatricula[] = $registro->id;
            }
        }

        return [
            'atualizados' => $atualizados,
            'sem_matricula' => $semMatricula
        ];
    }
}
