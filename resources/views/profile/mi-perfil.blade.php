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
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <img src="" alt="Cargando..." class="w-16 h-16 object-cover" id="imagen-resenha-{{ $resenha->id }}">
                            </td>
                            <td class="border border-gray-300 px-4 py-2" id="titulo-{{ $resenha->id }}"></td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resenha->valoracion }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $resenha->opinion_texto }}</td>
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
</div>

@endsection