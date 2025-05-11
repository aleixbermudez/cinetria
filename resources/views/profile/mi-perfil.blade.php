@extends('layouts.layout')
@section('title', 'Mi perfil')

@section('content')

@include('components.hero-perfil')
@include('components.slider-favoritas')

<div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-semibold text-gray-900">{{ $user->name }}</h1>
        <a href="{{ url('mi-perfil/editar') }}" class="text-gray-600 hover:text-gray-800 transition-colors flex items-center">
            Editar Perfil
        </a>
    </div>
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white">
    <div class="mb-8">
        <p class="text-gray-500">{{ $user->email }}</p>
    </div>

    <div class="space-y-8">
        @if($resenhas->count())
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="bg-amber-300 text-white">
                        <tr>
                            <th class="px-6 py-3">Imagen</th>
                            <th class="px-6 py-3">Título</th>
                            <th class="px-6 py-3">Valoración</th>
                            <th class="px-6 py-3">Opinión</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($resenhas as $resenha)
                            <tr class="hover:bg-gray-50"
                                data-tipo-contenido="{{ $resenha->tipo_contenido }}"
                                data-id-contenido="{{ $resenha->id_contenido }}"
                                id="resenha-{{ $resenha->id }}">
                                <td class="px-4 py-2">
                                    <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="flex items-center gap-3">
                                        <img src="" alt="Cargando..." class="w-16 h-16 object-cover" id="imagen-resenha-{{ $resenha->id }}">
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="flex items-center gap-3">
                                        <span class="nombre-contenido" id="titulo-{{ $resenha->id }}"></span>
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ $resenha->valoracion }}</td>
                                <td class="px-6 py-4">{{ $resenha->opinion_texto }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button 
                                        onclick="editResenha(
                                            '{{ $resenha->id }}',
                                            '{{ $user->name }}',
                                            '{{ $user->email }}',
                                            '{{ $resenha->valoracion }}',
                                            `{{ $resenha->opinion_texto }}`,
                                            '{{ $resenha->tipo_contenido }}',
                                            '{{ $resenha->created_at }}'
                                        )"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        Editar
                                    </button>

                                    <button 
                                        onclick="deleteResenha('{{ $resenha->id }}')"
                                        class="text-red-600 hover:text-red-800 ml-4"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $resenhas->links() }}
                </div>
            </div>
        @else
            <p class="text-gray-500">No tienes reseñas disponibles.</p>
        @endif
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const filas = document.querySelectorAll('tr[data-tipo-contenido]');
    filas.forEach(fila => {
        let tipo = fila.dataset.tipoContenido;
        const idTmdb = fila.dataset.idContenido;
        tipo = tipo === 'peliculas' ? 'movie' : 'tv';

        fetch(`https://api.themoviedb.org/3/${tipo}/${idTmdb}?language=es-ES`, {
            method: 'GET',
            headers: {
                accept: 'application/json',
                Authorization: 'Bearer TU_TOKEN_AQUI'
            }
        })
        .then(res => res.json())
        .then(data => {
            const nombre = data.title || data.name || 'Desconocido';
            const poster = data.poster_path ? `https://image.tmdb.org/t/p/w500${data.poster_path}` : '';
            const tituloEl = fila.querySelector('.nombre-contenido');
            const imagenEl = fila.querySelector('img');
            if (tituloEl) tituloEl.textContent = nombre;
            if (imagenEl && poster) imagenEl.src = poster;
        })
        .catch(err => console.error('Error al obtener datos de TMDB:', err));
    });
});

function deleteResenha(id) {
    Swal.fire({
        title: '¿Seguro que quieres eliminar esta reseña?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        customClass: {
            popup: 'text-left'
        },
        preConfirm: () => {
            return fetch(`/mi-perfil/resenhas/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('No se pudo eliminar la reseña');
                return response.json();
            })
            .then(() => {
                Swal.fire('Eliminada', 'La reseña ha sido eliminada correctamente.', 'success')
                    .then(() => location.reload());
            })
            .catch(err => {
                Swal.showValidationMessage(`Error: ${err.message}`);
            });
        }
    });
}

function editResenha(id, name, email, valoracion, opinionTexto, tipoContenido, createdAt) {
    Swal.fire({
        title: 'Editar Reseña',
        html: `
            <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                <label>Nombre del autor</label>
                <input id="swal-name" class="swal2-input" value="${name}" disabled>

                <label>Email del autor</label>
                <input id="swal-email" class="swal2-input" value="${email}" disabled>

                <label>Valoración</label>
                <input id="swal-valoracion" class="swal2-input" value="${valoracion}">

                <label>Texto de la opinión</label>
                <textarea id="swal-opinion" class="swal2-textarea">${opinionTexto}</textarea>

                <label>Tipo de contenido</label>
                <input id="swal-tipo" class="swal2-input" value="${tipoContenido}">

                <label>Fecha de reseña</label>
                <input id="swal-created" class="swal2-input" value="${createdAt}" disabled>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar cambios',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        customClass: {
            popup: 'text-left'
        },
        preConfirm: () => {
            const newValoracion = document.getElementById('swal-valoracion').value.trim();
            const newOpinionTexto = document.getElementById('swal-opinion').value.trim();
            const newTipoContenido = document.getElementById('swal-tipo').value.trim();

            if (!newValoracion || !newOpinionTexto || !newTipoContenido) {
                Swal.showValidationMessage('Todos los campos deben estar completos');
                return false;
            }

            return fetch(`/mi-perfil/resenhas/edit/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    valoracion: newValoracion,
                    opinion_texto: newOpinionTexto,
                    tipo_contenido: newTipoContenido
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('No se pudo actualizar la reseña');
                return response.json();
            })
            .then(() => {
                Swal.fire('Actualizada', 'La reseña ha sido modificada correctamente.', 'success')
                    .then(() => location.reload());
            })
            .catch(err => {
                Swal.showValidationMessage(`Error: ${err.message}`);
            });
        }
    });
}
</script>

@endsection
