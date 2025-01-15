@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 bg-white dark:bg-gray-800 p-5 rounded shadow">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-300 mb-4">Editar Funcionário</h1>

        <form action="{{ route('variavel.update', $variavel->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Codigo</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('nome', $variavel->codigo) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('codigo')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Descricao</label>
                <input type="text" name="descricao" id="descricao"
                    value="{{ old('descricao', $variavel->descricao) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('descricao')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            

            <div class="mt-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Salvar
                </button>
                <a href="{{ route('variaveis.list') }}"
                    class="ml-4 text-gray-800 dark:text-gray-300 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
