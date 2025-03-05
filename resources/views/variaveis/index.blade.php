@extends('layouts.app')

<html>

<head>
    <title>Gestão de Variáveis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


@section('content')

    <body>
        <div class="container mx-auto mt-5 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Gestão de Variáveis</h2>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 p-4 rounded mb-4">
                    <ul class="list-disc pl-5">
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

            <form class="flex flex-col sm:flex-row items-center gap-4 mb-6" action="{{ route('employee-variables.export') }}"
                method="GET">
                <select name="mes" id="mes" required
                    class="w-full sm:w-auto bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <option value="">Selecione um mês</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}">
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-indigo-600 text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 px-4 py-2 rounded-md flex items-center">
                    Exportar <i class="ri-file-excel-2-line ml-2"></i>
                </button>
            </form>

            <div class="flex flex-col justify-end gap-5 sm:flex-row  mb-6">
                <a href="{{ route('funcionario.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    Adicionar funcionário <i class="ri-user-add-line"></i>
                </a>
                <a href="{{ route('variavel.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    Adicionar Variável <i class="ri-article-fill"></i>
                </a>
                <a href="{{ route('funcionarios.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    Funcionarios <i class="ri-group-line"></i>
                </a>
                <a href="{{ route('variaveis.list') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    Variaveis<i class="ri-list-check"></i>
                </a>
            </div>

            <form id="variableForm" method="POST" action="{{ route('employee-variables.store') }}" class="mb-6">
                @csrf
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow mb-4">
                    <label for="employeeSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar
                        Funcionário:</label>
                    <input type="text" id="employeeSearch" name="employeeSearch" value="{{ old('employeeSearch') }}"
                        autocomplete="off"
                        class="mt-1 block w-full rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div id="employeeInfo" class="hidden bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow mb-4">
                    <input type="hidden" id="employee_id" name="employee_id">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="nome"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome:</label>
                            <input type="text" id="nome" name="nome"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                readonly>
                        </div>
                        <div>
                            <label for="matricula"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matrícula:</label>
                            <input type="text" id="matricula"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo:</label>
                            <input type="text" id="cargo"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seção:</label>
                            <input type="text" id="secao"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diretoria:</label>
                            <input type="text" id="diretoria"
                                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                readonly>
                        </div>
                        <!-- Adicione mais campos aqui conforme necessário -->
                    </div>
                </div>


                <div id="variableSection" class="hidden bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow mb-4"
                    style="display: none;">
                    <div class="card-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Código daVariável:
                                </label>
                                <input type="text" name="codigo_variavel" id="variableSearch"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                    autocomplete="off">
                                <input type="hidden" id="variable_id" name="variable_id">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Descrição:
                                </label>
                                <input type="text" id="descricao"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Quantidade:
                                </label>
                                <input type="text" id="quantity" name="quantity"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                    required placeholder="0,00">
                            </div>


                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Data de Referência:
                                </label>
                                <input type="date" value="{{ now()->format('Y-m-d') }}" name="reference_date"
                                    class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                    required>
                            </div>

                        </div>
                        <button type="submit"
                            class=" mt-2 bg-indigo-600 text-white dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 px-4 py-2 rounded-md flex items-center">

                            Salvar</button>
                    </div>
                </div>
            </form>



            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Variáveis Cadastradas</h3>
                <table class="min-w-full dark:text-gray-200 bg-white dark:bg-gray-800">
                    <thead class="bg-gray-200 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Funcionário</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Código
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Descrição
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
                                Quantidade</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Data
                                Ref.
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody id="variablesTable" class="divide-y divide-gray-200  dark:divide-gray-700">
                        <!-- Conteúdo dinâmico -->
                    </tbody>
                </table>
            </div>
        </div>




        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // Primeiro, declare loadEmployeeVariables globalmente
            let loadEmployeeVariables;

            $(document).ready(function() {
                let searchTimeout;

                $('#employeeSearch').on('input', function() {
                    clearTimeout(searchTimeout);
                    const searchTerm = $(this).val();

                    if (searchTerm.length >= 2) {
                        searchTimeout = setTimeout(function() {
                            $.ajax({
                                url: '/api/search-employees',
                                method: 'GET',
                                data: {
                                    search: searchTerm
                                },
                                success: function(response) {
                                    if (response.length > 0) {
                                        const employee = response[0];
                                        $('#employee_id').val(employee.id);
                                        $('#nome').val(employee.nome);
                                        $('#matricula').val(employee.matricula);
                                        $('#cargo').val(employee.cargo);
                                        $('#secao').val(employee.secao);
                                        $('#diretoria').val(employee.diretoria);
                                        $('#employeeInfo').show();
                                        $('#variableSection').show();
                                        loadEmployeeVariables(employee.id);
                                    }
                                }
                            });
                        }, 500);
                    }
                });

                $('#variableSearch').on('input', function() {
                    clearTimeout(searchTimeout);
                    const searchTerm = $(this).val();

                    if (searchTerm.length >= 2) {
                        searchTimeout = setTimeout(function() {
                            $.ajax({
                                url: '/api/search-variables',
                                method: 'GET',
                                data: {
                                    search: searchTerm
                                },
                                success: function(response) {
                                    if (response.length > 0) {
                                        const variable = response[0];
                                        $('#variable_id').val(variable.id);
                                        $('#descricao').val(variable.descricao);
                                    }
                                    console.log(response);
                                }
                            });
                        }, 500);
                    }
                });

                // Define loadEmployeeVariables como uma função global
                loadEmployeeVariables = function(employeeId) {
                    $.ajax({
                        url: '/api/employee-variables/' + employeeId,
                        method: 'GET',
                        success: function(response) {
                            $('#variablesTable').empty();
                            response.forEach(function(item) {
                                $('#variablesTable').append(`
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                ${item.funcionario.nome}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                ${item.variavel.codigo}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                ${item.variavel.descricao}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                ${item.quantidade}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                ${new Date(item.reference_date).toLocaleDateString('pt-BR')}</td>
                            <td>
                                <button class="text-red-300" onclick="deleteVariable(${item.id})">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    `);
                            });
                        }
                    });
                };
            });

            // Função de delete com SweetAlert
            function deleteVariable(id) {
                Swal.fire({
                    title: 'Confirmar exclusão',
                    text: 'Tem certeza que deseja excluir esta variável?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/employee-variables/' + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Excluído!',
                                        'A variável foi excluída com sucesso.',
                                        'success'
                                    );
                                    // Recarrega a tabela após excluir
                                    loadEmployeeVariables($('#employee_id').val());
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Erro!',
                                    'Erro ao excluir a variável.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>
@endsection
