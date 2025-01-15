@extends('layouts.app')

@section('content')
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>

<div class="container mx-auto mt-10 bg-white dark:bg-gray-800 p-5 rounded shadow">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-300 mb-4">Lista de Funcionários</h1>

    <!-- Formulário de Pesquisa -->
    <form action="{{ route('variaveis.list') }}" method="GET" class="mb-4">
        <div class="flex items-center space-x-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Pesquisar por codigo ou descrição"
                class="flex-grow rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-3 py-2"
            >
            <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
            >
                Pesquisar
            </button>
        </div>
    </form>

    <!-- Tabela de Funcionários -->
    <table class="w-full dark:text-gray-300 border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>

                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left text-gray-800 dark:text-gray-300">Código</th>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left text-gray-800 dark:text-gray-300">Descrição</th>
                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left text-gray-800 dark:text-gray-300">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($variaveis as $variavel)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $variavel->codigo }}</td>
                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $variavel->descricao }}</td>
                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                        <a href="{{ route('variavel.edit', $variavel->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">Nenhum funcionário encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="mt-4">
        {{ $variaveis->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection
