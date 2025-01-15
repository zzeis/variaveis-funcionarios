<?php

namespace App\Http\Controllers;

use App\Models\Variaveis;
use Illuminate\Http\Request;

class VariavelController extends Controller
{
    public function index()
    {
        $variaveis = Variaveis::all();
        return view('variaveis.index', compact('variaveis'));
    }

    public function list(Request $request)
    {
        $query = Variaveis::query();

        // Filtro de pesquisa
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('codigo', 'like', "%{$search}%")
                ->orWhere('descricao', 'like', "%{$search}%");
        }

        // Paginação
        $variaveis = $query->paginate(10);

        return view('variaveis.list', compact('variaveis'));
    }

    public function create()
    {
        return view('variaveis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'codigo' => 'required|string|unique:variaveis,codigo',
        ]);

        Variaveis::create($request->all());
        return redirect()->route('variavel.index')->with('success', 'Variável cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $variavel = Variaveis::findOrFail($id);
        return view('variaveis.edit', compact('variavel'));
    }
    public function update(Request $request, $id)
    {
        $variavel = Variaveis::findOrFail($id);

        $request->validate([
            'codigo' => 'required|unique:variaveis,codigo,' . $variavel->id,
            'descricao' => 'required|string|max:255',

        ]);

        $variavel->update([
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,

        ]);

        return redirect()->route('variaveis.list')->with('success', 'Variável atualizada com sucesso!');
    }
}
