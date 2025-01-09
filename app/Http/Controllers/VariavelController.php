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
}
