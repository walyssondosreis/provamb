<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastro de Produto</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">
        @error('nome')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br>
        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" value="{{ old('preco') }}">
        <br><br>
        <button type="submit">Salvar</button>
        <a href="{{ route('orcamentos.index') }}">Voltar ao menu</a>
    </form>
</body>
</html>
