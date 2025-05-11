@extends('layouts.layout')
@section('title', 'Perfil de ' . $user->name)

@section('content')

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900">Perfil de {{ $user->name }}</h2>
    </div>
    <h3 class="text-2xl font-semibold text-gray-900 text-center">Reseñas recientes</h3>
    <div id="contenedor-reseñas">
        @foreach($resenhas as $resenha)
        <div 
            class="reseña-card bg-white shadow-md rounded-lg overflow-hidden mb-6 border border-gray-200 hover:shadow-lg transition grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-4"
            data-tipo-contenido="{{ $resenha->tipo_contenido }}"
            data-id-contenido="{{ $resenha->id_contenido }}"
            id="resenha-{{ $resenha->id }}"
        >
            <!-- Imagen -->
            <div class="w-full sm:w-[120px] h-[180px] sm:h-auto">
                <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="flex items-center gap-3">
                    <img class="w-full h-full object-cover" src="/images/portada_404.png" alt="Portada" loading="lazy">
                </a>
            </div>

            <!-- Contenido -->
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm text-gray-500">
                            <a href="/perfil/{{ $resenha->usuario->name }}" class="text-gray-800 hover:text-indigo-600">
                                <span class="font-semibold">{{ $resenha->usuario->name ?? 'Usuario desconocido' }}</span> opinó sobre
                            </a>
                            <a href="/{{ $resenha->tipo_contenido }}/detalles/{{ $resenha->id_contenido }}" class="text-gray-800 hover:text-indigo-600">
                                <span class="text-indigo-600 font-medium nombre-contenido" data-default="Cargando...">Cargando...</span>
                            </a>
                        </div>
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($resenha->valoracion >= $i * 2)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.5 12.18.122 7.91l6.436-.54L10 1l3.442 6.37 6.436.54-5.378 4.27L15.878 18z"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.5 12.18.122 7.91l6.436-.54L10 1l3.442 6.37 6.436.54-5.378 4.27L15.878 18z"/></svg>
                                @endif
                            @endfor
                        </div>
                    </div>

                    <p class="text-gray-700 leading-relaxed text-sm">
                        {{ $resenha->opinion_texto ?? 'Sin comentario textual.' }}
                    </p>
                </div>

                <div class="text-xs text-gray-400 mt-4 text-right">
                    Publicado el {{ $resenha->created_at->format('d M Y, H:i') }}
                </div>
            </div>
            
        </div>
        @endforeach
        <div class="mt-6">
                    {{ $resenhas->links() }}
                </div>
        @if($resenhas->isEmpty())
            <p class="text-center text-gray-500">No hay reseñas todavía. ¡Sé el primero en compartir tu opinión!</p>
        @endif
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const reseñas = document.querySelectorAll('.reseña-card');
    reseñas.forEach(reseña => {
        var tipo = reseña.dataset.tipoContenido;
        var idTmdb = reseña.dataset.idContenido;

        if (tipo === 'peliculas') tipo = 'movie';
        if (tipo === 'series') tipo = 'tv';
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

// Función de búsqueda en tiempo real
function searchContent() {
    const input = document.getElementById('buscador');
    const query = input.value.toLowerCase();
    const reseñas = document.querySelectorAll('.reseña-card');

    reseñas.forEach(reseña => {
        const contenidoNombre = reseña.querySelector('.nombre-contenido').textContent.toLowerCase();
        const isMatch = contenidoNombre.includes(query);

        if (isMatch) {
            reseña.style.display = 'grid';  // Muestra el elemento si coincide
        } else {
            reseña.style.display = 'none';  // Oculta el elemento si no coincide
        }
    });
}
</script>

@endsection
