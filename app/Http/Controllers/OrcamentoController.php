<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\Produto;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('orcamentos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $produtos = Produto::all();
        $produtos = Produto::with('oferta')->get();
        $clientes = Pessoa::where('eh_cliente', 1)->get();
        $vendedores = Pessoa::where('eh_vendedor', 1)->get();

        $produtosJS = $produtos->mapWithKeys(function ($p) {
            return [$p->id => [
                'preco' => $p->preco,
                'qtd_levar' => optional($p->oferta)->qtd_levar,
                'qtd_pagar' => optional($p->oferta)->qtd_pagar,
            ]];
        });


        return view('orcamentos.create', compact('produtos', 'clientes', 'vendedores', 'produtosJS'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'cliente_id' => [
                    'required',
                    'different:vendedor_id',
                    'exists:pessoas,id,eh_cliente,1',
                ],
                'vendedor_id' => [
                    'required',
                    'different:cliente_id',
                    'exists:pessoas,id,eh_vendedor,1',
                ],
                'produtos' => 'required|array|min:1',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.qtd_produto' => 'required|integer|min:1',
                'produtos.*.preco_original_total' => 'required',
                'produtos.*.preco_final_total' => 'required',
            ],
            [
                'cliente_id' => 'Cliente não encontrado no sistema',
                'cliente_id.different' => 'Cliente e vendedor não podem ser iguais',
                'cliente_id.exists' => 'Cliente selecionado não é valido ou não está registrado',
                'vendedor_id' => 'Vendedor não encontrado no sistema',
                'vendedor_id.different' => 'Cliente e vendedor não podem ser iguais',
                'vendedor_id.exists' => 'Vendedor selecionado não é valido ou não está registrado',

            ]
        );

        $orcamento = Orcamento::create([
            'cliente_id' => $request->cliente_id,
            'vendedor_id' => $request->vendedor_id,
            'venda_concluida' => true,
        ]);

        foreach ($request->produtos as $produto) {

            $orcamento->produtos()->create([
                'produto_id' => $produto['produto_id'],
                'qtd_produto' => $produto['qtd_produto'],
                'aplica_oferta' => isset($produto['aplica_oferta']) ? 1 : 0,
                'preco_original_total' => $produto['preco_original_total'],
                'preco_final_total' => $produto['preco_final_total'],
            ]);
        }

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Relatório de orçamentos.
     */

    public function gerarRelatorio(Request $request)
    {
       $dataInicio = $request->input('data_inicio');
    $dataFim = $request->input('data_fim');
    $produtoId = $request->input('produto_id');
    $tipoVisao = $request->input('tipo_visao', 'orcamento');

    // Inicia a query com os relacionamentos necessários
    $query = Orcamento::with(['produtos', 'cliente', 'vendedor']);

    if ($dataInicio) {
        $query->whereDate('created_at', '>=', $dataInicio);
    }

    if ($dataFim) {
        $query->whereDate('created_at', '<=', $dataFim);
    }

    // Se um produto foi selecionado, filtramos orçamentos que o contenham
    if ($produtoId) {
        $query->whereHas('produtos', function ($subQuery) use ($produtoId) {
            $subQuery->where('produto_id', $produtoId);
        });
    }

    // Pegamos os orçamentos
    $orcamentos = $query->get();

    // Se o tipoVisao for "produto", filtramos os produtos DENTRO de cada orçamento
    if ($tipoVisao === 'produto' && $produtoId) {
        foreach ($orcamentos as $orcamento) {
            // substitui a relação produtos apenas com o produto filtrado
            $orcamento->setRelation('produtos', $orcamento->produtos->filter(function ($p) use ($produtoId) {
                return $p->produto_id == $produtoId;
            })->values());
        }
    }

    $clientes = Pessoa::where('eh_cliente', 1)->get();
    $vendedores = Pessoa::where('eh_vendedor', 1)->get();
    $produtos = Produto::all();

    return view('orcamentos.report', compact(
        'orcamentos',
        'clientes',
        'vendedores',
        'produtos',
        'dataInicio',
        'dataFim',
        'produtoId',
        'tipoVisao'
    ));
    }
}
