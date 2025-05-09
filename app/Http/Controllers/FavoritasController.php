<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorita;

class FavoritasController extends Controller
{
    public function toggle(Request $request, $tipo, $id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $favorita = Favorita::where('id_usuario', $user->id)
                            ->where('id_contenido', $id)
                            ->where('tipo_contenido', $tipo)
                            ->where('titulo_contenido', $request->input('titulo'))
                            ->first();
        if ($favorita!=null) {
            $favorita->delete();
        } else {
            Favorita::create([
                'id_usuario' => $user->id,
                'titulo_contenido' => $request->input('titulo'),
                'id_contenido' => $id, // ← aquí el cambio
                'tipo_contenido' => $request->input('tipo'),
            ]);

        }

        return back();
    }
}


