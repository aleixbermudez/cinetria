<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resenha extends Model
{
    protected $fillable = [
        'id_usuario', 'valoracion', 'opinion_texto', 'id_contenido', 'tipo_contenido'
    ];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}