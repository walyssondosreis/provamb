<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Models\Produto;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all();
        return view('ofertas.create', compact('produtos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'qtd_levar' => 'required|min:1',
            'qtd_pagar' => 'required|min:1',
        ]);

        if ((int) $request->qtd_levar <= (int) $request->qtd_pagar) {
            return back()
                ->withInput()
                ->withErrors(['qtd_levar' => 'A quantidade a levar deve ser maior que a quantidade a pagar.']);
        }

        Oferta::create([
            'produto_id' => $request->produto_id,
            'qtd_levar' => $request->qtd_levar,
            'qtd_pagar' => $request->qtd_pagar,
        ]);

        return redirect()->route('orcamentos.index')->with('success', 'Oferta cadastrada com sucesso!');
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
}
