<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resenha; // Asegúrate de importar el modelo de Resenha

class DashboardController extends Controller
{
    // Lógica para mostrar usuarios
    public function ListaUsuarios()
    {
        $users = User::all();
        return view('pages.dashboard.users', compact('users'));
    }

    // Lógica para editar un usuario
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['success' => true]);
    }

    // Lógica para eliminar un usuario
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    // Lógica para mostrar reseñas
    public function ListaResenhas()
    {
        // Obtener todas las reseñas, junto con el usuario que las creó
        $resenhas = Resenha::with('usuario')->get(); // Usamos with() para cargar la relación con el usuario

        return view('pages.dashboard.resenhas', compact('resenhas')); // Pasamos las reseñas a la vista
    }

    // Lógica para editar una reseña
    public function updateResenha(Request $request, Resenha $resenha)
    {
        $request->validate([
            'valoracion' => 'required|string|max:255',
            'opinion_texto' => 'nullable|string',
            'tipo_contenido' => 'required|string|max:255',
        ]);

        // Actualizar la reseña
        $resenha->update([
            'valoracion' => $request->valoracion,
            'opinion_texto' => $request->opinion_texto,
            'tipo_contenido' => $request->tipo_contenido,
        ]);

        return response()->json(['success' => true]);
    }

    // Lógica para eliminar una reseña
    public function deleteResenha($id)
    {
        try {
            $resenha = Resenha::findOrFail($id); // Buscar la reseña por su ID
            $resenha->delete(); // Eliminar la reseña

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
