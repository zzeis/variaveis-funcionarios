<?php

namespace App\Http\Controllers;

use App\Imports\FuncionariosImport;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::query();

        // Filtro de pesquisa
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('matricula', 'like', "%{$search}%");
        }

        // Paginação
        $funcionarios = $query->paginate(10);

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:funcionarios,matricula',
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'diretoria' => 'required|string|max:255',
            'secao' => 'required|string|max:255',
        ]);

        Funcionario::create($request->all());
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionarios.edit', compact('funcionario'));
    }
    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $request->validate([
            'matricula' => 'required|unique:funcionarios,matricula,' . $funcionario->id,
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'diretoria' => 'required|string|max:255',
            'secao' => 'required|string|max:255',
        ]);

        $funcionario->update([
            'nome' => $request->nome,
            'matricula' => $request->matricula,
            'cargo' => $request->cargo,
            'diretoria' => $request->diretoria,
            'secao' => $request->secao,
        ]);

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:5120'
        ]);

        $importId = uniqid();

        // Inicializa o progresso
        Cache::put("import_{$importId}", [
            'total' => 0,
            'processed' => 0,
            'percentage' => 0,
            'complete' => false
        ], now()->addMinutes(10));

        try {
            $import = new FuncionariosImport($importId);
            Excel::import($import, $request->file('file'));

            return response()->json([
                'success' => true,
                'import_id' => $importId,
                'message' => 'Importação concluída com sucesso!'
            ]);
        } catch (\Exception $e) {
            // Marca como erro no cache
            Cache::put("import_{$importId}", [
                'error' => true,
                'message' => $e->getMessage()
            ], now()->addMinutes(10));

            return response()->json([
                'success' => false,
                'message' => 'Erro ao importar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkProgress($importId)
    {
        $progress = Cache::get("import_{$importId}", [
            'total' => 0,
            'processed' => 0,
            'percentage' => 0,
            'complete' => false,
            'error' => false
        ]);

        return response()->json($progress);
    }

    // Nova rota para verificar progresso
    public function checkImportProgress($importId)
    {
        $progress = session('import_progress_' . $importId, [
            'total' => 0,
            'processed' => 0,
            'status' => 'not_found'
        ]);

        return response()->json($progress);
    }

    public function downloadTemplate()
    {
        return Excel::download(new class implements FromArray {
            public function array(): array
            {
                return [
                    ['matricula', 'nome', 'cargo', 'diretoria', 'secao'],
                    ['1001', 'João Silva', 'Analista', 'TI', 'Desenvolvimento'],
                    ['1002', 'Maria Souza', 'Gerente', 'RH', 'Recrutamento'],
                    ['1003', 'José Santos', 'Diretor', 'Financeiro', 'Contabilidade']
                ];
            }
        }, 'template_funcionarios.xlsx');
    }
}
