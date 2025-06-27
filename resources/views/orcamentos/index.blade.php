<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prova Minas Brasil</title>
     @vite('resources/css/app.css')
</head>

<body>
    <h1>MENU DE CADASTRO</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <div>
        <a href="{{ route('pessoas.create',['tipo'=>'cliente'])}}">Cliente</a><br>
        <a href="{{ route('pessoas.create',['tipo'=>'vendedor']) }}">Vendedor</a><br>
        <a href="{{ route('produtos.create') }}">Produto</a><br>
        <a href="{{ route('ofertas.create') }}">Oferta</a><br>
    </div>
    <br>
        <a href="{{ route('orcamentos.create') }}">Criar Orçamento</a><br>
        <a href="{{ route('orcamentos.report') }}">Relatório de Vendas</a><br>

</body>

</html>
