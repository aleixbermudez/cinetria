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

        // Validar que el título se haya enviado correctamente
        $titulo = $request->input('titulo');
        if (!$titulo) {
            return response()->json(['status' => 'error', 'message' => 'El título del contenido es obligatorio.'], 400);
        }

        // Buscar si el contenido ya está en los favoritos del usuario
        $favorita = Favorita::where('id_usuario', $user->id)
                            ->where('id_contenido', $id)
                            ->where('tipo_contenido', $tipo)
                            ->first();

        // Si ya está en favoritos, la eliminamos
        if ($favorita) {
            $favorita->delete();
            return response()->json(['status' => 'removed', 'message' => 'El contenido ha sido eliminado de tus favoritos.']);
        } 

        // Si no está en favoritos, lo agregamos
        Favorita::create([
            'id_usuario' => $user->id,
            'titulo_contenido' => $titulo,
            'id_contenido' => $id,
            'tipo_contenido' => $tipo,
        ]);

        return response()->json(['status' => 'added', 'message' => 'El contenido ha sido añadido a tus favoritos.']);
    }
}
