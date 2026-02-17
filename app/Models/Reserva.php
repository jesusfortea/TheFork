<?php
// Asegúrate de que el modelo Reserva.php tiene estas relaciones:

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = ['fecha_hora', 'id_user', 'id_restaurante'];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }
}