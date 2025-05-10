<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resenha extends Model
{
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_usuario');
    }
}
