<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    protected $table = 'restaurantes';
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'ubicacion',
        'precio',
        'cheff',
        'menu',
        'estado',
        'id_tipo'
    ];
    
    /**
     * Relación: Un restaurante pertenece a un tipo de cocina
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }
}
