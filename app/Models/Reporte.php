<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $fillable = ['motivo', 'usuario_id', 'usuario_reporta_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // En el modelo Reporte
    public function usuarioReporta()
    {
    return $this->belongsTo('App\Models\Usuario', 'usuario_reporta_id');
    }
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'usuario_id');
    }

}