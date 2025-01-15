@extends('layouts.app')



@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                timer: 3000, // Tempo em milissegundos (opcional)
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: "{{ session('error') }}",
                timer: 3000, // Tempo em milissegundos (opcional)
                showConfirmButton: false
            });
        @endif
    </script>

    <div class="container mx-auto mt-5 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
            Adicionar Funcionário
        </h2>
        <form id="func" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4"
            action="{{ route('funcionario.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matrícula
                </label>
                <input type="text" name="matricula"
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nome
                </label>
                <input type="text" name="nome"
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Cargo
                </label>
                <input type="text" name="cargo"
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Diretoria
                </label>
                <input type="text" name="diretoria"
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seção
                </label>
                <input type="text" name="secao"
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
            </div>


        </form>
        <button type="submit" form="func"
            class=" mt-2 bg-indigo-600 text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 px-4 py-2 rounded-md flex items-center">

            Salvar</button>
    </div>
@endsection
