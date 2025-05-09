<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorita extends Model
{
    protected $table = 'table_favoritas'; // nombre exacto de tu tabla

    protected $fillable = [
        'id_usuario',
        'titulo_contenido',
        'id_contenido',
        'tipo_contenido',
    ];

    public $timestamps = true;
}

