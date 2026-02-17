<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $table = 'resenas';

    protected $fillable = ['comentario', 'puntuacion', 'id_user', 'id_restaurante'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}