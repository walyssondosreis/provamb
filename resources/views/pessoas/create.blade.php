<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Pessoa</title>
</head>
<body>
    <h1>Cadastro de {{ ucfirst($tipo) }}</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('pessoas.store') }}" method="POST">
        @csrf

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">
        @error('nome')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br><br>
            <label {{ $tipo == 'cliente' ? 'hidden' : '' }}>
                <input
                    type="checkbox"
                    name="eh_cliente"
                    {{ $tipo == 'cliente' ? 'checked' : '' }}
                    onclick="return {{ $tipo == 'cliente' ? 'false' : 'true' }}"
                >
                Também é cliente?
            </label> <br>
            <label {{ $tipo == 'vendedor' ? 'hidden' : '' }}>
                <input
                    type="checkbox"
                    name="eh_vendedor"
                    {{ $tipo == 'vendedor' ? 'checked' : '' }}
                    onclick="return {{ $tipo == 'vendedor' ? 'false' : 'true' }}"
                >
                {{-- <input type="checkbox" name="eh_vendedor" {{ old('eh_vendedor') ? 'checked' : '' }}> --}}
                Também é vendedor?
            </label>
        <br><br>

        <button type="submit">Salvar</button>
        <a href="{{ route('orcamentos.index') }}">Voltar ao menu</a>
    </form>
</body>
</html>
