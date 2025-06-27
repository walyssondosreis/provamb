<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório Vendas</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tfoot tr td {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        tfoot tr td[colspan="4"],
        tfoot tr td[colspan="2"] {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Cadastro de Vendas</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('orcamentos.report') }}" method="GET">
        @csrf

        <hr>
        {{-- Aqui vai ficar os campos de filtro e busca --}}
        <label for="produto_id">Produto:</label>
        <select name="produto_id" id="produto_id">
            <option value="">Selecione um produto</option>
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}"
                    {{ old('produto_id', $produtoId ?? '') == $produto->id ? 'selected' : '' }}>
                    {{ $produto->id . ' - ' . $produto->nome }}
                </option>
            @endforeach
        </select>
        <br><br>

        <div>
            <input type="radio" id="visao_produto" name="tipo_visao" value="produto"
                {{ old('tipo_visao', $tipoVisao ?? 'orcamento') == 'produto' ? 'checked' : '' }}>
            <label for="visao_produto">Filtro de produto</label>
        </div>

        <div>
            <input type="radio" id="visao_orcamento" name="tipo_visao" value="orcamento"
                {{ old('tipo_visao', $tipoVisao ?? 'orcamento') == 'orcamento' ? 'checked' : '' }}>
            <label for="visao_orcamento">Filtro de orçamento</label>
        </div>

        <br><br>
        <label for="data_inicio">Data de Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', $dataInicio ?? '') }}">
        @error('data_inicio')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br>

        <label for="data_fim">Data de Fim:</label>
        <input type="date" name="data_fim" id="data_fim" value="{{ old('data_fim', $dataFim ?? '') }}">
        @error('data_fim')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br>

        <button type="submit">Buscar</button>
        <a href="{{ route('orcamentos.report') }}">Limpar Filtros</a>
        <hr>
        {{-- Aqui vai ficar a tabela de resultados --}}
        <table>
            <thead>
                <tr>
                    <th>Orçamento</th>
                    <th>Data</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Valor descontos</th>
                    <th>Valor pago</th>
                    <th>Produtos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orcamentos as $orcamento)
                    <tr>
                        <td>{{ $orcamento->id }} </td>
                        <td>{{ $orcamento->created_at->format('d/m/Y H:i:s') }} </td>
                        <td>{{ $orcamento->vendedor->id . ' - ' . $orcamento->vendedor->nome }} </td>
                        <td>{{ $orcamento->cliente->id . ' - ' . $orcamento->cliente->nome }} </td>
                        <td>
                            @if ($orcamento->produtos->isNotEmpty())
                                R$
                                {{ number_format($orcamento->produtos->sum('preco_original_total') - $orcamento->produtos->sum('preco_final_total'), 2, ',', '.') }}
                            @else
                                R$ 0,00
                            @endif
                        </td>
                        <td>
                            @if ($orcamento->produtos->isNotEmpty())
                                R$ {{ number_format($orcamento->produtos->sum('preco_final_total'), 2, ',', '.') }}
                            @else
                                R$ 0,00
                            @endif
                        </td>
                        <td>
                            @foreach ($orcamento->produtos as $p)
                                @if ($tipoVisao === 'orcamento' || ($tipoVisao === 'produto' && $produtoId == $p->produto->id))
                                    {{ $p->produto->id . ' - ' . $p->produto->nome . ' (x' . $p->qtd_produto . ')' }}<br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total Geral de Orçamentos:</strong></td>
                    <td colspan="2"> {{-- Ajuste o colspan para cobrir as colunas restantes --}}
                        <strong>
                            R$
                            {{ number_format(
                                $orcamentos->sum(function ($orcamento) {
                                    return $orcamento->produtos->sum('preco_final_total');
                                }),
                                2,
                                ',',
                                '.',
                            ) }}
                        </strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total de Descontos Aplicados:</strong></td>
                    <td colspan="2">
                        <strong>
                            R$
                            {{ number_format(
                                $orcamentos->sum(function ($orcamento) {
                                    return $orcamento->produtos->sum('preco_original_total') - $orcamento->produtos->sum('preco_final_total');
                                }),
                                2,
                                ',',
                                '.',
                            ) }}
                        </strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Quantidade de orçamentos:</strong></td>
                    <td colspan="2">
                        <strong>{{ $orcamentos->count() }}</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Quantidade total de produtos:</strong></td>
                    <td colspan="2">
                        <strong>
                            {{ $orcamentos->sum(function ($orcamento) {
                                return $orcamento->produtos->sum('qtd_produto');
                            }) }}
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        <hr>
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
