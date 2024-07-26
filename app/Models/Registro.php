<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'usuario_id',
        'comprador_id',
        'descripcion_pedido',
        'cantidad',
        'pedido',
    ];

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function comprador(){
        return $this->belongsTo(Usuario::class, 'comprador_id');
    }

}
