<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Orçamento</title>

    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
    }

    th, td {
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

    .valor-destaque {
        background-color: #e9ffe9;
        color: #0a5d0a;
        font-size: 1.1em;
    }

    .total-geral {
        background-color: #d9edf7;
        color: #31708f;
    }

    .desconto {
        background-color: #fff3cd;
        color: #856404;
    }

    .remover-produto {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .remover-produto:hover {
        background-color: #cc0000;
    }

    button[type="button"] {
        margin-top: 15px;
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="button"]:hover {
        background-color: #0056b3;
    }
</style>


</head>

<body>
    <h1>Cadastro de Orçamento</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('orcamentos.store') }}" method="POST">
        @csrf

        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <option value="">Selecione um cliente</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->id . ' - ' . $cliente->nome }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br>


        <label for="vendedor_id">Vendedor:</label>
        <select name="vendedor_id" id="vendedor_id">
            <option value="">Selecione um vendedor</option>
            @foreach ($vendedores as $vendedor)
                <option value="{{ $vendedor->id }}" {{ old('vendedor_id') == $vendedor->id ? 'selected' : '' }}>
                    {{ $vendedor->id . ' - ' . $vendedor->nome }}
                </option>
            @endforeach
        </select>
        @error('vendedor_id')
            <p style="color: red;">{{ $message }}</p>
        @enderror
        <br>
        <hr>
        {{-- Toda a parte de produtos organizadas em tabela --}}
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Aplica Oferta ?</th>
                    <th>Valor Unitário</th>
                    <th>Preço Original </th>
                    <th>Preço com Oferta </th>
                    <th>Ações </th>
                </tr>
            </thead>
            <tbody id="produtos">
                <tr>
                    <td>
                        <select name="produtos[0][produto_id]" id="produto_id_0" required>
                            <option value="">Selecione um produto</option>
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->id . ' - ' . $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" min="1" name="produtos[0][qtd_produto]" required>
                    </td>
                    <td>
                        <input type="checkbox" checked name="produtos[0][aplica_oferta]">
                    </td>
                    <td class="valor-unitario">R$ 0,00</td>
                    <td>
                        <span class="preco-original">R$ 0,00</span>
                        <input type="hidden" name="produtos[0][preco_original_total]" class="input-preco-original">
                    </td>
                    <td>
                        <span class="preco-oferta">R$ 0,00</span>
                        <input type="hidden" name="produtos[0][preco_final_total]" class="input-preco-oferta">
                    </td>
                    <td></td>

                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total</strong></td>
                    <td><strong id="total-original">R$ 0,00</strong></td>
                    <td><strong id="total-oferta">R$ 0,00</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Desconto aplicado:</strong></td>
                    <td colspan="2"><strong id="total-desconto">R$ 0,00</strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Valor total a pagar:</strong></td>
                    <td colspan="2"><strong id="total-pagar">R$ 0,00</strong></td>
                </tr>
            </tfoot>
        </table>

        {{-- Finaliza aqui --}}



        <button type="button" onclick="adicionarProduto()">+ Adicionar Produto</button>

        <br><br>
        <button type="submit">Concluir Venda</button>
        <a href="{{ route('orcamentos.index') }}">Salvar orçamento</a>
        <br>
        <a href="{{ route('orcamentos.index') }}">Voltar ao menu</a>
    </form>

    <template id="produto-template">
        <tr>
            <td>
                <select name="produtos[__index__][produto_id]" id="produto_id___index__" required>
                    <option value="">Selecione um produto</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->id . ' - ' . $produto->nome }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" min="1" name="produtos[__index__][qtd_produto]" required>
            </td>
            <td>
                <input type="checkbox" name="produtos[__index__][aplica_oferta]" checked>
            </td>
            <td class="valor-unitario">R$ 0,00</td>
            <td>
                <span class="preco-original">R$ 0,00</span>
                <input type="hidden" name="produtos[__index__][preco_original_total]" class="input-preco-original">
            </td>
            <td>
                <span class="preco-oferta"> R$ 0,00</span>
                <input type="hidden" name="produtos[__index__][preco_final_total]" class="input-preco-oferta">
            </td>
            <td>
                <button type="button" class="remover-produto">X</button>
            </td>

        </tr>
    </template>


    @php
        // dd($produtosJS);
        // foreach ($produtos as $prod) {
        //     var_dump($prod->oferta->qtd_levar);
        //     var_dump($prod->oferta->qtd_pagar);
        // }
    @endphp

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

    <script>
        let index = 1; // Global

        function aplicarSelect2() {
            document.querySelectorAll('[id^="produto_id_"]').forEach(function(select) {
                if (!$(select).hasClass("select2-hidden-accessible")) {
                    $(select).select2({
                        placeholder: 'Selecione um produto',
                        allowClear: true,
                        language: 'pt-BR'
                    });
                }
            });
        }

        function adicionarProduto() {
            const template = document.getElementById('produto-template').innerHTML;
            const html = template.replace(/__index__/g, index);
            const tbody = document.getElementById('produtos');

            const wrapper = document.createElement('tbody');
            wrapper.innerHTML = html;
            const newRow = wrapper.firstElementChild;

            newRow.setAttribute('data-index', index); // Agora seguro

            newRow.querySelector('.remover-produto').addEventListener('click', function() {
                newRow.remove();
                atualizarTotais();
            });

            // Registra eventos de mudança para inputs/selects
            newRow.querySelectorAll('select, input').forEach(function(el) {
                el.addEventListener('change', () => atualizarPrecos(newRow));
                el.addEventListener('input', () => atualizarPrecos(newRow));
            });

            tbody.appendChild(newRow);
            aplicarSelect2();
            atualizarPrecos(newRow);
            index++; // Agora incrementa corretamente
        }

        function formatarPreco(valor) {
            return valor.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }

        function atualizarTotais() {
            let totalOriginal = 0;
            let totalOferta = 0;

            document.querySelectorAll('#produtos tr').forEach(function(tr) {
                const index = tr.getAttribute('data-index');
                if (!index) return;

                const produtoId = parseInt(tr.querySelector(`[name="produtos[${index}][produto_id]"]`).value);
                const quantidade = parseInt(tr.querySelector(`[name="produtos[${index}][qtd_produto]"]`).value) ||
                0;
                const aplicaOferta = tr.querySelector(`[name="produtos[${index}][aplica_oferta]"]`).checked;
                const produto = produtosData[produtoId];

                if (!produto || !quantidade) return;

                const precoUnitario = parseFloat(produto.preco);
                const precoOriginal = precoUnitario * quantidade;
                let precoFinal = precoOriginal;

                if (aplicaOferta && produto.qtd_levar && produto.qtd_pagar) {
                    const descontos = Math.floor(quantidade / produto.qtd_levar);
                    const restante = quantidade % produto.qtd_levar;
                    const totalPagar = (descontos * produto.qtd_pagar) + restante;
                    precoFinal = totalPagar * precoUnitario;
                }

                totalOriginal += precoOriginal;
                totalOferta += precoFinal;
            });

            const totalDesconto = totalOriginal - totalOferta;

            document.getElementById('total-original').textContent = formatarPreco(totalOriginal);
            document.getElementById('total-oferta').textContent = formatarPreco(totalOferta);
            document.getElementById('total-desconto').textContent = formatarPreco(totalDesconto);
            document.getElementById('total-pagar').textContent = formatarPreco(totalOferta);
        }


        function atualizarPrecos(tr) {
            const index = tr.getAttribute('data-index');
            const produtoId = parseInt(tr.querySelector(`[name="produtos[${index}][produto_id]"]`).value);
            const quantidade = parseInt(tr.querySelector(`[name="produtos[${index}][qtd_produto]"]`).value) || 0;
            const aplicaOferta = tr.querySelector(`[name="produtos[${index}][aplica_oferta]"]`).checked;

            const produto = produtosData[produtoId];
            if (!produto || !quantidade) return;

            const precoUnitario = parseFloat(produto.preco);
            const precoOriginal = precoUnitario * quantidade;

            let precoFinal = precoOriginal;

            if (aplicaOferta && produto.qtd_levar && produto.qtd_pagar) {
                const descontos = Math.floor(quantidade / produto.qtd_levar);
                const restante = quantidade % produto.qtd_levar;
                const totalPagar = (descontos * produto.qtd_pagar) + restante;
                precoFinal = totalPagar * precoUnitario;
            }

            tr.querySelector('.valor-unitario').textContent = formatarPreco(precoUnitario);
            tr.querySelector('.preco-original').textContent = formatarPreco(precoOriginal);
            tr.querySelector('.preco-oferta').textContent = formatarPreco(precoFinal);
            tr.querySelector('.input-preco-original').value = precoOriginal.toFixed(2);
            tr.querySelector('.input-preco-oferta').value = precoFinal.toFixed(2);

            atualizarTotais();
        }


        $(document).ready(function() {
            aplicarSelect2();

            $('#cliente_id').select2({
                placeholder: 'Selecione um cliente',
                allowClear: true,
                language: 'pt-BR'
            });

            $('#vendedor_id').select2({
                placeholder: 'Selecione um vendedor',
                allowClear: true,
                language: 'pt-BR'
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const tr = document.querySelector('#produtos tr');
            tr.setAttribute('data-index', 0);

            tr.querySelectorAll('select, input').forEach(function(el) {
                el.addEventListener('change', () => atualizarPrecos(tr));
                el.addEventListener('input', () => atualizarPrecos(tr));
            });

            atualizarPrecos(tr);
        });

        const produtosData = @json($produtosJS);
    </script>





</body>

</html>
