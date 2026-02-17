<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    protected $table = 'restaurantes';
    
    protected $fillable = ['titulo', 'descripcion', 'imagen', 'ubicacion', 'precio', 'cheff', 'menu', 'id_tipo', 'estado'];
    
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_restaurante');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'id_restaurante');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'restaurante_etiquetas', 'id_restaurante', 'id_etiqueta');
    }
}