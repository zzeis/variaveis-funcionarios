@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 bg-white dark:bg-gray-800 p-5 rounded shadow">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-300 mb-4">Editar Funcionário</h1>

        <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Nome</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $funcionario->nome) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('nome')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Matricula</label>
                <input type="text" name="matricula" id="matricula"
                    value="{{ old('matricula', $funcionario->matricula) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('matricula')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Cargo</label>
                <input type="text" name="cargo" id="cargo" value="{{ old('cargo', $funcionario->cargo) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('cargo')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Cargo</label>
                <input type="text" name="diretoria" id="diretoria"
                    value="{{ old('diretoria', $funcionario->diretoria) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('diretoria')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Cargo</label>
                <input type="text" name="secao" id="secao" value="{{ old('secao', $funcionario->secao) }}" required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('secao')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>


            <div class="mt-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Salvar
                </button>
                <a href="{{ route('funcionarios.index') }}"
                    class="ml-4 text-gray-800 dark:text-gray-300 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
