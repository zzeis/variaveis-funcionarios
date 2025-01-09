<html>

<head>
    <title>Gestão de Variáveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>



<body>
    <div class="container mt-5">
        <h2></h2>
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

        <div>

            <form class="row " action="{{ route('employee-variables.export') }}" method="GET">
                <label>Selecione o mês</label>
                <span class="col-md-4">
                
                    <select class="form-select w-50" name="mes" id="mes" required>
                        <option value="">Selecione um mês</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}">
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                </span>
                <span class="col-md-2">
                    <button type="submit" class="btn btn-primary ">exportar <i
                            class="ri-file-excel-2-line"></i></button>
                </span>


            </form>

            {{-- <a class="col-md-3" style="text-decoration: none" href="{{ route('funcionario.create') }}">
                Adicionar funcionario
                <i class="ri-user-add-line"></i></a>
            <a class="col-md-3" style="text-decoration: none" href="{{ route('variavel.create') }}">
                Adicionar Variavel
                <i class="ri-article-fill"></i> --}}
        </div>

        <form id="variableForm" method="POST" action="{{ route('employee-variables.store') }}">
            @csrf
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Buscar Funcionário:</label>
                            <input type="text" value="{{ old('employeeSearch') }}" name="employeeSearch"
                                id="employeeSearch" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div id="employeeInfo" class="row" style="display: none;">
                        <input type="hidden" id="employee_id" name="employee_id">

                        <div class="col-md-3 mb-3">
                            <label>Nome:</label>
                            <input value="{{ old('nome') }}" name="nome" type="text" id="nome"
                                class="form-control" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Matrícula:</label>
                            <input type="text" id="matricula" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Cargo:</label>
                            <input type="text" id="cargo" class="form-control" readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Seção:</label>
                            <input type="text" id="secao" class="form-control" readonly>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label>Diretoria:</label>
                            <input type="text" id="diretoria" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div id="variableSection" class="card mb-4" style="display: none;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Código da Variável:</label>
                            <input type="text" name="codigo_variavel" id="variableSearch" class="form-control"
                                autocomplete="off">
                            <input type="hidden" id="variable_id" name="variable_id">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Descrição:</label>
                            <input type="text" id="descricao" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Quantidade:</label>
                            <input type="number" name="quantity" class="form-control" step="0.01" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Data de Referência:</label>
                            <input type="date" value="{{ old('reference_date', now()->format('d/m/Y')) }}>"
                                name="reference_date" class="form-control" required>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <h5>Variáveis Cadastradas</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Data Ref.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="variablesTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            let searchTimeout;

            $('#employeeSearch').on('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = $(this).val();

                if (searchTerm.length >= 3) {
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

            function loadEmployeeVariables(employeeId) {
                $.ajax({
                    url: '/api/employee-variables/' + employeeId,
                    method: 'GET',
                    success: function(response) {
                        $('#variablesTable').empty();
                        response.forEach(function(item) {
                            $('#variablesTable').append(`
                            <tr>
                                <td>${item.funcionario.nome}</td>
                                <td>${item.variavel.codigo}</td>
                                <td>${item.variavel.descricao}</td>
                                <td>${item.quantidade}</td>
                                <td>${item.reference_date}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="deleteVariable(${item.id})">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        `);
                        });
                    }
                });
            }
        });

        function deleteVariable(id) {
            if (confirm('Tem certeza que deseja excluir esta variável?')) {
                $.ajax({
                    url: '/employee-variables/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Recarrega a tabela após excluir
                            loadEmployeeVariables($('#employee_id').val());
                        }
                    },
                    error: function(xhr) {
                        alert('Erro ao excluir a variável');
                    }
                });
            }
        }
    </script>
</body>

</html>
