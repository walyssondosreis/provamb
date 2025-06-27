<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrcamentoProduto extends Model
{
    protected $fillable = [
        'orcamento_id',
        'produto_id',
        'qtd_produto',
        'preco_original_total',
        'preco_final_total',
        'aplica_oferta',
    ];

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id','id');
    }
}
