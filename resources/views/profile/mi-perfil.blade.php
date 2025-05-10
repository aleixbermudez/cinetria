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
                                    <a href="{{ url('resenha/editar/'.$resenha->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                                    <form action="{{ url('resenha/eliminar/'.$resenha->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-4">Eliminar</button>
                                    </form>
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const filas = document.querySelectorAll('tr[data-tipo-contenido]');

    filas.forEach(fila => {
        let tipo = fila.dataset.tipoContenido;
        const idTmdb = fila.dataset.idContenido;

        // Traducir a lo que TMDB espera
        tipo = tipo === 'peliculas' ? 'movie' : 'tv';

        fetch(`https://api.themoviedb.org/3/${tipo}/${idTmdb}?language=es-ES`, {
            method: 'GET',
            headers: {
                accept: 'application/json',
                Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
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
</script>

@endsection
