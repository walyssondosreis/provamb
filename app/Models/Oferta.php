<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'produto_id',
        'qtd_levar',
        'qtd_pagar',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class,'produto_id','id');
    }
}
