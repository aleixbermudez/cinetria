@extends('layouts.layout')
@section('title', 'Mi perfil')

@section('content')

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Mi Perfil</h1>
    <div class="flex items-center space-x-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-700">{{$user->name}}</h2>
            <p class="text-gray-500">{{$user->email}}</p>
        </div>
    </div>
    <div class="space-y-4">
        @if($resenhas->count())
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    MIS RESEÑAS 
                </thead>
                <tbody>
                    @foreach($resenhas as $resenha)
                        <tr class="reseña-card bg-white shadow-md rounded-lg overflow-hidden mb-6 border border-gray-200 hover:shadow-lg transition grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-4"
                            data-tipo-contenido="{{ $resenha->tipo_contenido }}"
                            data-id-contenido="{{ $resenha->id_contenido }}"
                            id="resenha-{{ $resenha->id }}">
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="flex items-center gap-3">
                                    <img src="" alt="Cargando..." class="w-16 h-16 object-cover" id="imagen-resenha-{{ $resenha->id }}">
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="flex items-center gap-3">
                                    <span class="nombre-contenido" id="titulo-{{ $resenha->id }}"></span>
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resenha->valoracion }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resenha->opinion_texto }}</td>
                        </tr>
                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const reseñas = document.querySelectorAll('.reseña-card');
                            reseñas.forEach(reseña => {
                                const tipo = reseña.dataset.tipoContenido === 'peliculas' ? 'movie' : 'tv';
                                const idTmdb = reseña.dataset.idContenido;

                                fetch(`https://api.themoviedb.org/3/${tipo}/${idTmdb}?language=es-ES`, {
                                    method: 'GET',
                                    headers: {
                                        accept: 'application/json',
                                        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
                                    }
                                })
                                .then(res => res.json())
                                .then(contentData => {
                                    const nombreContenido = reseña.querySelector('.nombre-contenido');
                                    const imagen = reseña.querySelector('img');

                                    if (contentData.title || contentData.name) {
                                        nombreContenido.textContent = contentData.title || contentData.name;
                                    }

                                    if (contentData.poster_path) {
                                        imagen.src = `https://image.tmdb.org/t/p/w500${contentData.poster_path}`;
                                    }
                                })
                                .catch(err => console.error('Error fetching content data:', err));
                            });
                        });
                        </script>
                    @endforeach
                </tbody>

            </table>
            <div class="mt-4">
                {{ $resenhas->links() }}
            </div>
        @else
            <p class="text-gray-500">No hay reseñas disponibles.</p>
        @endif
    <div class="mt-6">
        <a href="{{ url('perfil/editar') }}" class="inline-block px-6 py-2 text-black bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md">
            Editar Perfil
        </a>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $user->name }}</h2>
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
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <img src="" alt="Cargando..." class="w-20 h-20 object-cover rounded-md" id="imagen-resenha-{{ $resenha->id }}">
                                </td>
                                <td class="px-6 py-4" id="titulo-{{ $resenha->id }}"></td>
                                <td class="px-6 py-4">{{ $resenha->valoracion }}</td>
                                <td class="px-6 py-4">{{ $resenha->opinion_texto }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ url('resenha/editar/'.$resenha->id) }}" class="text-blue-600 hover:text-blue-800">
                                        Editar
                                    </a>
                                    <form action="{{ url('resenha/eliminar/'.$resenha->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-4">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const tipo = '{{ $resenha->tipo_contenido }}'; // 'movie' o 'tv'
                                    const id = '{{ $resenha->id_contenido }}';
                                    const filaId = '{{ $resenha->id }}'; // ID único de la reseña

                                    fetch(`https://api.themoviedb.org/3/${tipo}/${id}?language=es-ES`, {
                                        method: 'GET',
                                        headers: {
                                            accept: 'application/json',
                                            Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        const titulo = tipo === 'movie' ? data.title : data.name;
                                        const imagen = data.poster_path
                                            ? `https://image.tmdb.org/t/p/w500${data.poster_path}`
                                            : 'https://via.placeholder.com/100x150?text=No+Imagen';

                                        document.getElementById('titulo-' + filaId).innerText = titulo;
                                        document.getElementById('imagen-resenha-' + filaId).src = imagen;
                                    })
                                    .catch(err => console.error('Error al obtener datos de TMDB:', err));
                                });
                            </script>
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

@endsection
