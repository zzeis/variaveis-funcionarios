<head>
    <title>Nova variavel</title>
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

    body {
        margin-top: 10%;
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
<div class="container">
    <div class="">

        <div class="text-center">
            <a class="text-center" href="{{ route('/') }}"><i class="ri-home-2-line"></i></a>
        </div>
        <h5 class="text-center">Adicionar Variavel </h5>


        <form class="w-50 mx-auto" action="{{ route('variavel.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Codigo</label>
                <input type="text" name="codigo" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Descricao</label>
                <input type="text" name="descricao" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-4">Salvar</button>
        </form>
    </div>
</div>
