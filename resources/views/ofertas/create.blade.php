<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Oferta</title>
</head>
<body>
    <h1>Cadastro de Oferta</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('ofertas.store') }}" method="POST">
        @csrf

        <label for="produto_id">Produto:</label>
                <select name="produto_id" id="produto_id" required>
                <option value="">Selecione um produto</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->id.' - '. $produto->nome }}</option>
                    @endforeach
                </select>
        <br><br>

        <label for="qtd_levar">Quantidade p/ Levar:</label>
        <input type="number" name="qtd_levar" id="qtd_levar" value="{{ old('qtd_levar') }}">
        @error('qtd_levar')
            <div style="color:red;">{{ $message }}</div>
        @enderror
        <br><br>

        <label for="qtd_pagar">Quantidade p/ Pagar:</label>
        <input type="number" name="qtd_pagar" id="qtd_pagar" value="{{ old('qtd_pagar') }}">
        <br><br>

        <button type="submit">Salvar</button>
        <a href="{{ route('orcamentos.index') }}">Voltar ao menu</a>
    </form>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

    <script>
        $(document).ready(function() {

            $('#produto_id').select2({
                placeholder: 'Selecione um produto',
                allowClear: true,
                language: 'pt-BR'
            });
        });
    </script>
</body>
</html>
