<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MODELO LIKE
 * 
 * Este modelo representa la relación "Me gusta" entre un usuario y un restaurante.
 * Cuando un usuario da like a un restaurante, se crea un registro en la tabla 'likes'.
 */
class Like extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'likes';
    
    /**
     * CAMPOS ASIGNABLES EN MASA
     * Estos campos pueden ser asignados directamente cuando se crea un Like
     * Ejemplo: Like::create(['id_user' => 1, 'id_restaurante' => 5, 'like' => true])
     */
    protected $fillable = [
        'id_user',           // ID del usuario que dio like
        'id_restaurante',    // ID del restaurante que recibió el like
        'like'               // Boolean: true si es like
    ];
    
    /**
     * RELACIÓN: Un like pertenece a un Usuario
     * 
     * Esta relación permite acceder al usuario que dio el like.
     * Uso: $like->user->name (obtiene el nombre del usuario que dio like)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    /**
     * RELACIÓN: Un like pertenece a un Restaurante
     * 
     * Esta relación permite acceder al restaurante que recibió el like.
     * Uso: $like->restaurante->titulo (obtiene el nombre del restaurante)
     */
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}
