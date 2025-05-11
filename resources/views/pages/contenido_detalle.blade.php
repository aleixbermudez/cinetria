@extends('layouts.layout')
@section('title', $movie['titulo'])

@section('content')
    <div class="dark:bg-neutral-900">

        {{-- Buscador --}}
        <div class="relative z-40 mb-12">
            @include('components.buscador')
        </div>

        <div class="container mx-auto space-y-16 px-4 sm:px-6 lg:px-8">

            {{-- Título --}}
            <h1 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white">
                {{ $movie['titulo'] }}
            </h1>

            {{-- Contenido principal --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Poster --}}
                <div class="flex justify-center">
                    <img src="{{ $movie['poster_url'] }}" alt="Poster de {{ $movie['titulo'] }}"
                        class="rounded-2xl shadow-xl w-auto object-cover">
                </div>

                {{-- Detalles --}}
                <div class="lg:col-span-2 space-y-10">

                    {{-- Detalles Generales --}}
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6 space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Detalles Generales</h2>
                        <ul class="space-y-1 text-gray-700 dark:text-neutral-300">
                            <li><strong>Año:</strong> {{ $movie['anho'] }}</li>
                            <li><strong>Puntuación TMDB:</strong> {{ $movie['valoracion'] }}</li>
                            <li><strong>Sinopsis:</strong> {{ $movie['resumen'] }}</li>
                        </ul>
                        <div class="flex items-center justify-between">
                            <div>
                                {{-- Siempre se muestra el botón de "Crear Reseña", sin importar si está logeado --}}
                                @auth
                                    @if ($resenhaExistente)
                                        <p class="text-sm text-gray-700 dark:text-neutral-300">
                                            Ya has creado una reseña.
                                            <b><a href="{{ route('mi-perfil') }}" class="bold hover:underline">
                                                    Modifícala desde tu perfil
                                                </a>.</b>
                                        </p>
                                    @else
                                        <button id="crear-resena-btn"
                                            class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-5 rounded-full transition">
                                            Crear Reseña
                                        </button>
                                    @endif
                                @else
                                    <a href="/login">
                                        <button
                                            class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-5 rounded-full transition">
                                            Crear Reseña
                                        </button>
                                    </a>
                                @endauth
                            </div>
                            <div>
                                @auth
                                    <form id="favorite-form" action="{{ route('pelicula.favorita', ['tipo' => $tipo, 'id' => $movie['id']]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="titulo" value="{{ $movie['titulo'] }}">
                                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                                        <input type="hidden" name="id" value="{{ $movie['id'] }}">
                                        <button type="submit" id="likeBtn"
                                            class="mt-4 text-black font-medium py-2 px-5 rounded-full transition flex items-center gap-2">
                                            @if ($favorita)
                                                <!-- Corazón relleno y coloreado -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                </svg>
                                            @else
                                                <!-- Corazón vacío -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.6-8.55 11.54L12 21.35z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="/login">
                                        <button class="mt-4 text-white font-medium py-2 px-5 rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.6-8.55 11.54L12 21.35z" />
                                            </svg>
                                        </button>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Detalles Adicionales --}}
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6 space-y-4">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Detalles Adicionales</h2>
                        <ul class="space-y-1 text-gray-700 dark:text-neutral-300">
                            <li><strong>Géneros:</strong>
                                @foreach ($movie['generos'] as $genero)
                                    {{ $genero['nombre'] }}@if (!$loop->last), @endif
                                @endforeach
                            </li>
                            @if ($tipo == 'series')
                                <li><strong>Temporadas:</strong> {{ $movie['temporadas'] }}</li>
                                <li><strong>Episodios totales:</strong> {{ $movie['episodios'] }}</li>
                            @elseif ($tipo == 'peliculas')
                                <li><strong>Duración:</strong> {{ $movie['duracion'] }} minutos</li>
                                <li><strong>Presupuesto:</strong> {{ $movie['presupuesto'] }} </li>
                                <li><strong>Recaudación:</strong> {{ $movie['recaudacion'] }} </li>
                            @endif
                            <li><strong>Idioma Original:</strong> {{ $movie['idioma_original'] }}</li>
                            <li><strong>Fecha de Estreno:</strong> {{ $movie['fecha_estreno'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Reparto --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center mb-8">Reparto</h2>
                <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach ($movie['reparto'] as $actor)
                        <li class="text-center space-y-2">
                            <a href="/personas/detalles/{{ $actor['id'] }}" class="block">
                                <img src="{{ $actor['foto'] ?? asset('images/portada_404.png') }}" 
                                    alt="Foto de {{ $actor['nombre'] }}"
                                    class="w-20 h-20 object-cover rounded-full mx-auto shadow">
                                <div class="text-gray-900 dark:text-white font-medium">
                                    {{ $actor['nombre'] }}
                                </div>
                                <div class="text-gray-500 dark:text-neutral-400 text-sm">
                                    {{ $actor['personaje'] }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($tipo == 'peliculas')
                {{-- Equipo --}}
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center mb-8">Equipo</h2>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        @foreach ($movie['equipo'] as $miembro)
                            <li class="text-center space-y-2">
                                <a href="/personas/detalles/{{ $miembro['id'] }}" class="block">
                                    <img src="{{ $miembro['foto'] ?? asset('images/portada_404.png') }}" 
                                        alt="Foto de {{ $miembro['nombre'] }}"
                                        class="w-20 h-20 object-cover rounded-full mx-auto shadow">
                                    <div class="text-gray-900 dark:text-white font-medium">
                                        {{ $miembro['nombre'] }}
                                    </div>
                                    <div class="text-gray-500 dark:text-neutral-400 text-sm">
                                        {{ $miembro['cargo'] }}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- AJAX para manejar la lógica de añadir y quitar favoritos --}}
    <script>
        document.getElementById('favorite-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const likeBtn = document.getElementById('likeBtn');
            const isFavorited = likeBtn.querySelector('svg').classList.contains('text-red-500');
            
            // Realizamos la petición AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                // Si se añadió a favoritos
                if (data.status === 'added') {
                    if (!isFavorited) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Añadido correctamente!',
                            text: 'La película ha sido añadida a tus favoritos.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                    likeBtn.querySelector('svg').classList.replace('text-gray-500', 'text-red-500');
                } 
                // Si se quitó de favoritos
                else if (data.status === 'removed') {
                    if (isFavorited) {
                        Swal.fire({
                            icon: 'warning',  // Cambio de success a warning
                            title: '¡Eliminado correctamente!',
                            text: 'La película ha sido eliminada de tus favoritos.',
                            showConfirmButton: false,
                            timer: 2000,
                            imageUrl: 'https://img.icons8.com/ios/452/trash.png', // Icono de basura
                            imageWidth: 50,
                            imageHeight: 50,
                            imageAlt: 'Basura icono',
                        });
                    }
                    likeBtn.querySelector('svg').classList.replace('text-red-500', 'text-gray-500');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al procesar tu solicitud.',
                    showConfirmButton: true
                });
            });
        });

        document.getElementById('crear-resena-btn').addEventListener('click', function () {
        // Verificamos si el usuario está logeado utilizando una variable global de PHP
            @auth
            Swal.fire({
                title: '{{ $movie['titulo'] }}',
                html: `
                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px; overflow: hidden;">
                    <form id="resena-form" action="{{ route('resenhas.crear') }}" method="POST" style="width: 100%;">
                    @csrf
                    <input type="hidden" name="id_contenido" value="{{ $movie['id'] }}">
                    <input type="hidden" name="tipo_contenido" value="{{ $tipo }}">
                    <textarea id="opinion_texto" name="opinion_texto" class="swal2-textarea" placeholder="¿Qué te ha parecido?" style="width: 80%; resize: none; height: 100px;"></textarea>
                    <label for="valoracion" style="font-weight: 500;">Puntuación:</label>
                    <input type="range" id="valoracion" name="valoracion" min="1" max="10" value="5" step="1" style="width: 100%; margin-bottom: 10px;">
                    <div id="valor-valoracion" style="font-size: 16px; font-weight: bold; text-align: center; color: #4B5563;">5</div>
                    </form>
                </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#EF4444',
                confirmButtonText: 'Guardar reseña',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                const opinion_texto = document.getElementById('opinion_texto').value.trim();
                const valoracion = document.getElementById('valoracion').value;

                if (!opinion_texto || !valoracion) {
                    Swal.showValidationMessage('Por favor, escribe una reseña y selecciona una puntuación.');
                    return false;
                }

                // Submit the form
                document.getElementById('resena-form').submit();
                }
            }).then(result => {
                if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Reseña guardada!',
                    text: 'Gracias por compartir tu opinión.',
                    timer: 6500,
                    showConfirmButton: false
                });
                console.log('Reseña:', result.value);

            const form = this;
            const likeBtn = document.getElementById('likeBtn');
            const isFavorited = likeBtn.querySelector('svg').classList.contains('text-red-500');
            
            // Realizamos la petición AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                // Si se añadió a favoritos
                if (data.status === 'added') {
                    if (!isFavorited) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Añadido correctamente!',
                            text: 'La película ha sido añadida a tus favoritos.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                    likeBtn.querySelector('svg').classList.replace('text-gray-500', 'text-red-500');
                } 
                // Si se quitó de favoritos
                else if (data.status === 'removed') {
                    if (isFavorited) {
                        Swal.fire({
                            icon: 'warning',  // Cambio de success a warning
                            title: '¡Eliminado correctamente!',
                            text: 'La película ha sido eliminada de tus favoritos.',
                            showConfirmButton: false,
                            timer: 2000,
                            imageUrl: 'https://img.icons8.com/ios/452/trash.png', // Icono de basura
                            imageWidth: 50,
                            imageHeight: 50,
                            imageAlt: 'Basura icono',
                        });
                    }
                    likeBtn.querySelector('svg').classList.replace('text-red-500', 'text-gray-500');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al procesar tu solicitud.',
                    showConfirmButton: true
                });
            });

            // Manejador de evento para mostrar el valor de la puntuación
            document.getElementById('valoracion').addEventListener('input', function() {
                document.getElementById('valor-valoracion').textContent = this.value;
            });
            @else
            // Si el usuario no está logeado, redirige al login
            window.location.href = '/login';
            @endauth
        });
    </script>
@endsection
