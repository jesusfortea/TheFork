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

    /**
     * RELACIÓN: Un restaurante puede tener muchos Likes
     * 
     * Esta relación permite obtener todos los likes que ha recibido un restaurante.
     * Uso: $restaurante->likes (obtiene colección de likes)
     * Uso: $restaurante->likes()->count() (cuenta cuántos likes tiene)
     * 
     * @return HasMany Relación con el modelo Like
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_restaurante');
    }
}