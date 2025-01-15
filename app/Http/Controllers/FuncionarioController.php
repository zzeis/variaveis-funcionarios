<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

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
}
