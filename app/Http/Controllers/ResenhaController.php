<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resenha;
use Illuminate\Support\Facades\Auth;

class ResenhaController extends Controller
{
    // Utilizado para crear reseñas de peliculas o series

    function crearResenha(Request $request)
    {
        if ($request->oper == 'elim') {
            $resenha = Resenha::find($request->id);
            $resenha->delete();

            $salida = redirect()->route('perfil');
        } else {
            $datosValidados = $request->validate([
                'valoracion'            => 'required|integer|min:1|max:10',
            ], [
                'valoracion.required'   => 'Debes incluir una valoración',
                'valoracion.integer'    => 'La valoración debe ser un numero entre 1 y 10',
                'valoracion.min'        => 'La valoración mínima es 1',
                'valoracion.max'        => 'La valoración máxima es 10'
            ]);

            $idUsuario = Auth::user()->id;

            // Verificar si ya existe una reseña para este usuario, tipo y contenido
            $resenhaExistente = Resenha::where('id_usuario', $idUsuario)
                ->where('tipo_contenido', $request->tipo_contenido)
                ->where('id_contenido', $request->id_contenido)
                ->first();

            if ($resenhaExistente && empty($request->id)) {
                return redirect()->back()->withErrors(['error' => 'Ya existe una reseña para este contenido.']);
            }

            $resenha = empty($request->id) ? ($resenhaExistente ?? new Resenha()) : Resenha::find($request->id);

            $resenha->id_usuario     = $idUsuario;
            $resenha->valoracion     = $request->valoracion;
            $resenha->opinion_texto  = $request->opinion_texto;
            $resenha->tipo_contenido = $request->tipo_contenido;
            $resenha->id_contenido   = $request->id_contenido;

            $resenha->save();

            sleep(1);
            $salida = redirect()->back();
        }

        return $salida;
    }

    public function foro()
    {
        $resenhas = Resenha::with('usuario')->latest()->get(); // Asume que tienes relación con User
        return view('pages.foro', compact('resenhas'));
    }


    public function destroy($id)
    {
        $resenha = Resenha::findOrFail($id);
        $resenha->delete();

        return response()->json(['message' => 'Reseña eliminada correctamente.']);
    }

    public function update(Request $request, $id)
    {
        $resenha = Resenha::findOrFail($id);

        $request->validate([
            'valoracion' => 'required|numeric|min:0|max:10',
            'opinion_texto' => 'required|string',
            'tipo_contenido' => 'required|string|in:peliculas,series',
        ]);

        $resenha->valoracion = $request->valoracion;
        $resenha->opinion_texto = $request->opinion_texto;
        $resenha->tipo_contenido = $request->tipo_contenido;
        $resenha->save();

        return response()->json(['message' => 'Reseña actualizada correctamente.']);
    }



    
    // Opciones para crear, modificar, eliminar o mostrar reseñas ( CRUD)
    function mostrarResenha($id)
    {
        return $this->formularioResenha('cons' , $id);
    }

    function eliminarResenha($id)
    {
        return $this->formularioResenha('elim' , $id);
    }

    function modificarResenha($id)
    {
        return $this->formularioResenha('modi' , $id);
    }

    function nuevaResenha()
    {
        return $this->formularioResenha();
    }
}
