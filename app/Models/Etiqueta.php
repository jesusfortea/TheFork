<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    
    protected $fillable = ['nombre', 'tipo'];
    
    public function restaurantes()
    {
        return $this->belongsToMany(Restaurante::class, 'restaurante_etiquetas', 'id_etiqueta', 'id_restaurante');
    }
}