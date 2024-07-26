<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buscar extends Model
{
    protected $fillable = ['term', 'count','Imagen'];
    use HasFactory;
    public function busquedasPro() {
        return $this->belongsTo(Producto::class);
    }
}
