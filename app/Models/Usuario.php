<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        // ... otras propiedades
        'es_admin',
    ];

    public function Productos(){
        return $this-> hasMany(Producto::class); 
    }

    public function Favoritos(){
        return $this-> hasMany(Favorito::class); 
    }

    public function Ofertas(){
        return $this-> hasMany(Oferta::class); 
    }

    public function Pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function Registros(){
        return $this->hasMany(Registro::class);
    }

    public function Comentarios(){
        return $this->hasMany(Comentario::class);
    }
}
