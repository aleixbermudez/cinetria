<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorita;

class FavoritasController extends Controller
{
    // Método para agregar o eliminar una película/serie de los favoritos
    public function toggle(Request $request, $tipo, $id)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Debes iniciar sesión primero.'], 401);
        }

        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Buscar si la película ya está en los favoritos del usuario
        $favorita = Favorita::where('id_usuario', $user->id)
                            ->where('id_contenido', $id)
                            ->where('tipo_contenido', $tipo)
                            ->first();

        // Si ya está en favoritos, la eliminamos, si no la agregamos
        if ($favorita) {
            $favorita->delete();
            return response()->json(['status' => 'removed', 'message' => 'La película ha sido eliminada de tus favoritos.']);
        } else {
            Favorita::create([
                'id_usuario' => $user->id,
                'titulo_contenido' => $request->input('titulo'),
                'id_contenido' => $id,
                'tipo_contenido' => $request->input('tipo'),
            ]);
            return response()->json(['status' => 'added', 'message' => 'La película ha sido añadida a tus favoritos.']);
        }
    }
}
