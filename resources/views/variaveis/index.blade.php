@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Cabeçalho -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestão de Variáveis</h1>
            </div>

            <!-- Alertas -->
            @if ($errors->any())
                <div
                    class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 p-4 border-l-4 border-red-500 mb-4 mx-6">
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

            <div class="p-6 space-y-6">
                <!-- Exportação -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Exportar Dados</h2>
                    <form class="flex flex-col sm:flex-row items-center gap-4"
                        action="{{ route('employee-variables.export') }}" method="GET">
                        <div class="w-full sm:w-64">
                            <select name="mes" id="mes" required
                                class="w-full bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Selecione um mês</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}">
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-40 h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition duration-150 ease-in-out flex items-center justify-center">
                            <i class="ri-file-excel-2-line mr-2"></i>
                            Exportar
                        </button>
                    </form>
                </div>

                <!-- Links rápidos -->
                <div class="flex flex-wrap gap-3 justify-end">
                    <a href="{{ route('funcionario.create') }}"
                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        <i class="ri-user-add-line mr-1"></i> Adicionar funcionário
                    </a>
                    <a href="{{ route('variavel.create') }}"
                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        <i class="ri-article-fill mr-1"></i> Adicionar Variável
                    </a>
                    <a href="{{ route('funcionarios.index') }}"
                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        <i class="ri-group-line mr-1"></i> Funcionários
                    </a>
                    <a href="{{ route('variaveis.list') }}"
                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        <i class="ri-list-check mr-1"></i> Variáveis
                    </a>
                </div>

                <!-- Importação -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Importar Funcionários</h2>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('funcionarios.download-template') }}"
                            class="w-full sm:w-40 h-10 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-150 ease-in-out">
                            <i class="ri-download-line mr-2"></i> Baixar Modelo
                        </a>

                        <form action="{{ route('funcionarios.import') }}" method="POST" enctype="multipart/form-data"
                            class="flex flex-col sm:flex-row items-center gap-4 w-full">
                            @csrf
                            <div class="w-full flex-grow">
                                <input type="file" name="file" accept=".csv, .xlsx, .xls"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                dark:file:bg-indigo-900 dark:file:text-indigo-300
                                dark:hover:file:bg-indigo-800">
                            </div>
                            <button type="submit"
                                class="w-full sm:w-40 h-10 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="ri-upload-line mr-2"></i> Importar
                            </button>
                        </form>
                    </div>

                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Faça o download do modelo, preencha com os dados de todos os funcionários e faça o upload para
                        atualizar a base.
                    </p>
                </div>

                <!-- Formulário de Variáveis -->
                <form id="variableForm" method="POST" action="{{ route('employee-variables.store') }}" class="space-y-6">
                    @csrf
                    <!-- Busca de Funcionário -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Buscar Funcionário</h2>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="ri-search-line text-gray-500 dark:text-gray-400"></i>
                            </div>
                            <input type="text" id="employeeSearch" name="employeeSearch"
                                value="{{ old('employeeSearch') }}" autocomplete="off"
                                placeholder="Digite o nome ou matrícula do funcionário"
                                class="pl-10 block w-full rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-2 px-4">
                        </div>
                    </div>

                    <!-- Informações do Funcionário -->
                    <div id="employeeInfo" class="hidden bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informações do Funcionário</h2>
                        <input type="hidden" id="employee_id" name="employee_id">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label for="nome"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome:</label>
                                <input type="text" id="nome" name="nome"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                            <div>
                                <label for="matricula"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Matrícula:</label>
                                <input type="text" id="matricula" name="matricula"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                            <div>
                                <label for="cargo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cargo:</label>
                                <input type="text" id="cargo"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                            <div>
                                <label for="secao"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seção:</label>
                                <input type="text" id="secao"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                            <div>
                                <label for="diretoria"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diretoria:</label>
                                <input type="text" id="diretoria"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Seção de Variáveis -->
                    <div id="variableSection" class="hidden bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Adicionar Variável</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="variableSearch"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Código da Variável:
                                </label>
                                <input type="text" name="codigo_variavel" id="variableSearch"
                                    placeholder="Digite o código"
                                    class="block w-full rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-2 px-4"
                                    autocomplete="off">
                                <input type="hidden" id="variable_id" name="variable_id">
                            </div>
                            <div>
                                <label for="descricao"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Descrição:
                                </label>
                                <input type="text" id="descricao"
                                    class="block w-full rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 py-2 px-4"
                                    readonly>
                            </div>
                            <div>
                                <label for="quantity"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Quantidade:
                                </label>
                                <input type="text" id="quantity" name="quantity" placeholder="0,00" required
                                    class="block w-full rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-2 px-4">
                            </div>
                            <div>
                                <label for="reference_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Data de Referência:
                                </label>
                                <input type="date" id="reference_date" name="reference_date"
                                    value="{{ now()->format('Y-m-d') }}" required
                                    class="block w-full rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-2 px-4">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                class="w-40 h-10 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="ri-save-line mr-2"></i> Salvar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabela de Variáveis -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Variáveis Cadastradas</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Funcionário
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Código
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Descrição
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Quantidade
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Data Ref.
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="variablesTable"
                                class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                                <!-- Conteúdo dinâmico -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    ${item.funcionario.nome}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    ${item.variavel.codigo}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    ${item.variavel.descricao}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    ${item.quantidade}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                    ${new Date(item.reference_date).toLocaleDateString('pt-BR')}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button class="text-red-500 hover:text-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 rounded" 
                                            onclick="deleteVariable(${item.id})">
                                        <i class="ri-delete-bin-line mr-1"></i> Excluir
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

        $('form[enctype="multipart/form-data"]').submit(function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let $form = $(this);
            
            // Mostra o modal de progresso
            const progressModal = Swal.fire({
                title: 'Importando Funcionários',
                html: `
                    <div class="text-center">
                        <div class="mb-2 text-sm" id="importStatus">Preparando importação...</div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div id="importProgressBar" class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <div id="importProgressText" class="mt-2 text-sm">0/0 registros</div>
                    </div>
                `,
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
            // Envia o formulário
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        const importId = response.import_id;
                        checkProgress(importId);
                    }
                },
                error: function(xhr) {
                    progressModal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: xhr.responseJSON?.message || 'Erro ao iniciar importação',
                        confirmButtonText: 'OK'
                    });
                }
            });
            
            function checkProgress(importId) {
                const progressInterval = setInterval(() => {
                    $.ajax({
                        url: `/funcionarios/import/progress/${importId}`,
                        type: 'GET',
                        success: function(progress) {
                            // Atualiza a interface
                            $('#importProgressBar').css('width', progress.percentage + '%');
                            $('#importProgressText').text(`${progress.processed}/${progress.total} registros`);
                            
                            if (progress.complete) {
                                clearInterval(progressInterval);
                                $('#importStatus').text('Finalizando...');
                                
                                setTimeout(() => {
                                    progressModal.close();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Importação concluída com sucesso!',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }, 1000);
                            }
                            
                            if (progress.error) {
                                clearInterval(progressInterval);
                                progressModal.close();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: progress.message || 'Erro durante a importação',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            clearInterval(progressInterval);
                            progressModal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Não foi possível verificar o progresso',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }, 1000); // Verifica a cada 1 segundo
            }
        });
    </script>
@endsection
