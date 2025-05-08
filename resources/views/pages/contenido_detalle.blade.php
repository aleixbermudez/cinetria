@extends('layouts.layout')
@include('components.navbar')
@section('title', $movie['titulo'])

@section('content')
<div class="dark:bg-neutral-900 py-12">

    {{-- Buscador --}}
    <div class="relative z-40 mb-12">
        @include('components.buscador')
    </div>

    <div class="max-w-6xl mx-auto space-y-16 px-4 sm:px-6 lg:px-8">

        {{-- Título --}}
        <h1 class="text-4xl font-extrabold text-center text-gray-900 dark:text-white">
            {{ $movie['titulo'] }}
        </h1>

        {{-- Contenido principal --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Poster --}}
            <div class="flex justify-center">
                <img src="{{ $movie['poster_url'] }}" alt="Poster de {{ $movie['titulo'] }}"
                    class="rounded-2xl shadow-xl w-full max-w-xs">
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
                    <div>
                        <button class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-5 rounded-full transition">
                            Crear Reseña
                        </button>
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
                        <li><strong>Duración:</strong> {{ $movie['duracion'] }} minutos</li>
                        <li><strong>Idioma Original:</strong> {{ $movie['idioma_original'] }}</li>
                        <li><strong>Presupuesto:</strong> {{ $movie['presupuesto'] }}</li>
                        <li><strong>Recaudación:</strong> {{ $movie['recaudacion'] }}</li>
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
                        <a href="/personas/{{ $actor['id'] }}" class="block">
                            {{-- Si no hay foto, mostrar una imagen por defecto --}}
                            <img src="{{ $actor['foto'] }}" alt="Foto de {{ $actor['nombre'] }}"
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
    </div>
</div>
@endsection
