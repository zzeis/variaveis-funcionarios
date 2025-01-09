<head>
    <title>Novo funcionario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    a {
        text-decoration: none;
    }
</style>

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
<div class="container mt-5">
    <a href="{{ route('/') }}"><i class="ri-home-2-line"></i></a>
    <h1>Adicionar Funcionário</h1>
    <form action="{{ route('funcionario.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Matrícula</label>
            <input type="text" name="matricula" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Cargo</label>
            <input type="text" name="cargo" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Diretoria</label>
            <input type="text" name="diretoria" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Seção</label>
            <input type="text" name="secao" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-4">Salvar</button>
    </form>
</div>
