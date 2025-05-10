@extends('layouts.layout')

@section('title', 'Foro de Opiniones')

@section('content')

@include('components.hero-foro')
<div class="container mx-auto px-4 py-8">

    <!-- Buscador -->
    <div class="max-w-xl mx-auto mb-8">
        <form class="relative w-full" autocomplete="off">
            <div class="flex items-center gap-2 bg-white rounded-lg shadow p-2">
                <input
                    id="buscador"
                    type="text"
                    placeholder="Buscar película o serie..."
                    class="flex-grow px-4 py-2 text-sm rounded-lg bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none"
                />
            </div>
            <div id="resultados"
                class="absolute z-20 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow hidden max-h-[300px] overflow-y-auto">
            </div>
        </form>
    </div>

    <!-- Reseñas -->
    <div id="contenedor-reseñas">
        @foreach($resenhas as $resenha)
        <div 
            class="reseña-card bg-white shadow-md rounded-lg overflow-hidden mb-6 border border-gray-200 hover:shadow-lg transition grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-4"
            data-tipo="{{ $resenha->tipo_contenido }}"
            data-idtmdb="{{ $resenha->id_contenido }}"
            id="resenha-{{ $resenha->id }}"
        >
            <!-- Imagen -->
            <div class="w-full sm:w-[120px] h-[180px] sm:h-auto">
                <img class="w-full h-full object-cover" src="/images/portada_404.png" alt="Portada" loading="lazy">
            </div>

            <!-- Contenido -->
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm text-gray-500">
                            <span class="font-semibold">{{ $resenha->usuario->name ?? 'Usuario desconocido' }}</span> opinó sobre 
                            <span class="text-indigo-600 font-medium nombre-contenido" data-default="Cargando...">Cargando...</span>
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

        @if($resenhas->isEmpty())
            <p class="text-center text-gray-500">No hay reseñas todavía. ¡Sé el primero en compartir tu opinión!</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsIm5iZiI6MTczODMxNjcyMS4yNjgsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s';

        const reseñas = document.querySelectorAll(".reseña-card");
        reseñas.forEach(async (card) => {
            const tipo = card.dataset.tipo;
            const idTMDB = card.dataset.idtmdb;
            const spanNombre = card.querySelector('.nombre-contenido');
            const img = card.querySelector('img');

            let url = '';
            if (tipo === 'pelicula') {
                url = `https://api.themoviedb.org/3/movie/${idTMDB}?language=es-ES`;
            } else if (tipo === 'serie') {
                url = `https://api.themoviedb.org/3/tv/${idTMDB}?language=es-ES`;
            }

            try {
                const response = await fetch(url, {
                    headers: {
                        accept: 'application/json',
                        Authorization: `Bearer ${token}`
                    }
                });
                const data = await response.json();
                const nombre = data.title || data.name || 'Contenido desconocido';
                const portada = data.poster_path ? `https://image.tmdb.org/t/p/w300${data.poster_path}` : '/images/portada_404.png';

                spanNombre.textContent = nombre;
                img.src = portada;
                img.alt = nombre;
            } catch (error) {
                console.error('Error al obtener datos de TMDb:', error);
                spanNombre.textContent = 'Error al cargar contenido';
            }
        });

        // --- Buscador ---
        const buscador = document.querySelector('#buscador');
        const resultadosDiv = document.querySelector('#resultados');
        const contenedorReseñas = document.querySelector('#contenedor-reseñas');

        buscador.addEventListener('keyup', async function () {
            const query = buscador.value.trim();
            if (!query) {
                resultadosDiv.classList.add('hidden');
                resultadosDiv.innerHTML = '';
                mostrarTodasReseñas();
                return;
            }

            try {
                const response = await fetch(`https://api.themoviedb.org/3/search/multi?query=${encodeURIComponent(query)}&include_adult=false&language=es-ES&page=1`, {
                    method: 'GET',
                    headers: {
                        accept: 'application/json',
                        Authorization: `Bearer ${token}`
                    }
                });
                const data = await response.json();
                let html = '';

                data.results.slice(0, 10).forEach(item => {
                    const tipo = item.media_type === 'movie' ? 'pelicula'
                                 : item.media_type === 'tv' ? 'serie'
                                 : null;
                    if (!tipo) return;

                    const id = item.id;
                    const nombre = item.title || item.name;
                    const img = item.poster_path ? `https://image.tmdb.org/t/p/w92${item.poster_path}` : '/images/portada_404.png';

                    html += `
                        <div class="hover:bg-gray-100 cursor-pointer p-2">
                            <div class="flex items-center gap-3" onclick="filtrarResenas('${tipo}', '${id}')">
                                <img src="${img}" class="w-10 h-auto rounded shadow-sm" alt="${nombre}">
                                <span class="text-sm font-medium text-gray-800">${nombre}</span>
                            </div>
                        </div>
                    `;
                });

                resultadosDiv.innerHTML = html;
                resultadosDiv.classList.remove('hidden');
            } catch (error) {
                console.error('Error al buscar:', error);
                resultadosDiv.innerHTML = '<p class="p-4 text-red-500">Error al cargar resultados</p>';
                resultadosDiv.classList.remove('hidden');
            }
        });

        window.filtrarResenas = (tipo, id) => {
            reseñas.forEach(card => {
                const cardTipo = card.dataset.tipo;
                const cardId = card.dataset.idtmdb;
                card.style.display = (cardTipo === tipo && cardId === id) ? 'grid' : 'none';
            });
            resultadosDiv.classList.add('hidden');
        }

        function mostrarTodasReseñas() {
            reseñas.forEach(card => card.style.display = 'grid');
        }
    });
</script>
@endsection
