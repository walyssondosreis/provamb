@extends('layouts.app')
@section('title', 'ProvaMB: Cadastrar de Produto')

@section('content')
    <h1>Cadastro de Produto</h1>

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
        <a href="{{ route('orcamentos.index') }}">Voltar</a>
    </form>
@endsection
