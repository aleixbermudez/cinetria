@extends('layouts.layout')

@section('title', 'Foro de Opiniones')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Foro de Opiniones</h1>

    @foreach($resenhas as $resenha)
    <div 
        class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200 hover:shadow-lg transition flex gap-6 items-start"
        data-tipo="{{ $resenha->tipo_contenido }}"
        data-idtmdb="{{ $resenha->id_contenido }}"
        id="resenha-{{ $resenha->id }}"
    >
        <img src="/images/portada_404.png" alt="Portada" class="w-24 h-auto rounded shadow-md object-cover poster">

        <div class="flex-1">
            <div class="flex justify-between items-center mb-2">
                <div class="text-sm text-gray-500">
                    <span class="font-semibold">{{ $resenha->usuario->name ?? 'Usuario desconocido' }}</span> opinó sobre 
                    <span class="text-indigo-600 font-medium nombre-contenido" data-default="Cargando...">Cargando...</span>
                </div>
                <div class="text-yellow-500 font-semibold">
                    Valoración: {{ $resenha->valoracion }}/10
                </div>
            </div>
            <p class="text-gray-700 leading-relaxed italic">
                "{{ $resenha->opinion_texto ?? 'Sin comentario textual.' }}"
            </p>
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

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4OGEzMjE5MTAxNTZiZWFlZWY1MzBlYzNhMmQxNTg5MSIsInN1YiI6IjY3OWM5YmIxODIyZTdkMzJmN2JkZTg2MiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.TnYuqSvLds-SafDDSVYFrCieAvhOqtG0kstT95IPt1s';

        const resenhas = document.querySelectorAll("[id^='resenha-']");

        resenhas.forEach(async (card) => {
            const tipo = card.dataset.tipo; // "pelicula" o "serie"
            const idTMDB = card.dataset.idtmdb; // ID de la película o serie
            const spanNombre = card.querySelector('.nombre-contenido');
            const img = card.querySelector('.poster');

            // Verificar si el id y tipo están presentes
            if (!idTMDB || !tipo) {
                console.error("Faltan datos de ID o tipo para cargar contenido");
                return;
            }

            let url = `https://api.themoviedb.org/3/${tipo === 'pelicula' ? 'movie' : 'tv'}/${idTMDB}?language=es-ES`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        accept: 'application/json',
                        Authorization: `Bearer ${token}`
                    }
                });

                // Verificar si la respuesta es correcta
                if (!response.ok) {
                    throw new Error(`Error al obtener datos de TMDb: ${response.statusText}`);
                }

                const data = await response.json();

                // Verificar si la API ha devuelto los datos correctos
                if (!data || (!data.title && !data.name)) {
                    console.error("No se han encontrado datos válidos para esta película o serie");
                    spanNombre.textContent = 'Contenido desconocido';
                    img.src = '/images/portada_404.png';
                    img.alt = 'Error al cargar imagen';
                    return;
                }

                // Obtener título y poster
                const nombre = data.title || data.name || 'Contenido desconocido';
                const poster = data.poster_path
                    ? `https://image.tmdb.org/t/p/w300${data.poster_path}`
                    : '/images/portada_404.png';

                // Actualizar título y imagen en el HTML
                spanNombre.textContent = nombre;
                img.src = poster;
                img.alt = nombre;

            } catch (error) {
                console.error('Error al obtener datos de TMDb:', error);
                spanNombre.textContent = 'Error al cargar contenido';
                img.src = '/images/portada_404.png';
                img.alt = 'Error al cargar imagen';
            }
        });
    });
</script>
@endsection
