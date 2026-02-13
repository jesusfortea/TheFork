<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    
    protected $fillable = ['id_user', 'id_restaurante', 'fecha_hora'];
    
    /**
     * Relación: Una reserva pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    /**
     * Relación: Una reserva pertenece a un restaurante
     */
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}
