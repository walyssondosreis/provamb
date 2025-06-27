<?php

namespace App\Models;

use App\Models\OrcamentoProduto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'vendedor_id',
        'venda_concluida',
    ];

    public function produtos()
    {
        return $this->hasMany(OrcamentoProduto::class);
    }
    public function vendedor()
    {
        return $this->belongsTo(Pessoa::class, 'vendedor_id', 'id');
    }
     public function cliente()
    {
        return $this->belongsTo(Pessoa::class,'cliente_id','id');
    }
}
