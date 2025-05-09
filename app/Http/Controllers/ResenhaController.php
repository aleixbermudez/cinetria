<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResenhaController extends Controller
{
    // Utilizado para crear reseñas de peliculas o series

    function crearResenha(Request $request)
    {
        if ($request->oper == 'elim')
        {

            $resenha = Resenha::find($request->id);
            $resenha->delete();

            $salida = redirect()->route('perfil');
        }
        else
        {

            $datosValidados = $request->validate([
                'valoracion'            => 'required|integer|min:1|max:10',
            ],[
                'valoracion.required'   => 'Debes incluir una valoración',
                'valoracion.integer'    => 'La valoración debe ser un numero entre 1 y 10',
                'valoracion.min'        => 'La valoración mínima es 1',
                'valoracion.max'        => 'La valoración máxima es 10'
            ]);


            $resenha = empty($request->id)? new Resenha() : Resenha::find($request->id);

            $id                   = Auth::user()->id;
            $resenha->id_usuario  = $id;
            $resenha->valoracion  = $request->valoracion;
            $resenha->opinion_texto = $request->opinion_texto;
            $resenha->titulo_contenido = $request->titulo_contenido;
            $resenha->tipo_contenido = $request->tipo_contenido;
            $resenha->id_contenido = $request->id_contenido;

            $resenha->save();


            $salida = redirect()->route('resenhas.crear')->with([
                    'success'  => 'Reseña creada correctamente'
                    ,'formData' => $resenha
                ]
            );

        }

        return $salida;
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
