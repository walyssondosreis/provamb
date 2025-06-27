<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\OrcamentoController;

Route::get('/',[OrcamentoController::class,'index'])->name('orcamentos.index');
Route::get('/pessoas/create/{tipo}', [PessoaController::class, 'create'])->name('pessoas.create');
Route::post('/pessoas', [PessoaController::class, 'store'])->name('pessoas.store');
Route::get('/produtos/create',[ProdutoController::class, 'create'])->name('produtos.create');
Route::post('/produtos',[ProdutoController::class, 'store'])->name('produtos.store');
Route::get('/ofertas/create',[OfertaController::class, 'create'])->name('ofertas.create');
Route::post('/ofertas',[OfertaController::class, 'store'])->name('ofertas.store');
Route::get('/orcamentos/create',[OrcamentoController::class, 'create'])->name('orcamentos.create');
Route::post('/orcamentos',[OrcamentoController::class, 'store'])->name('orcamentos.store');
Route::get('/orcamentos/report',[OrcamentoController::class, 'gerarRelatorio'])->name('orcamentos.report');
