@extends('layouts.app')
@section('title', 'ProvaMB: Cadastrar de Oferta')

@section('content')
    <h1>Cadastro de Oferta</h1>

    <form action="{{ route('ofertas.store') }}" method="POST">
        @csrf

        <label for="produto_id">Produto:</label>
        <select name="produto_id" id="produto_id" required>
            <option value="">Selecione um produto</option>
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}">{{ $produto->id . ' - ' . $produto->nome }}</option>
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
        <a href="{{ route('orcamentos.index') }}">Voltar</a>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#produto_id').select2({
                placeholder: 'Selecione um produto',
                allowClear: true,
                language: 'pt-BR'
            });
        });
    </script>
@endsection
