@extends('layouts.layout')
@include('components.navbar')
@section('title', $movie['titulo'])
<div id="container flex justify-center items-center w-full">
        <div class="container mx-auto">
            @include('components.buscador')
        </div>
@section('content')
<h1 class="text-3xl font-bold mb-6 text-center">{{ $movie['titulo'] }}</h1>
<div class="container mx-auto px-4 py-8">
    <div class="flex">
        <div class="bg-yellow-400 rounded-lg shadow-md p-4 mr-4 mt-auto flex justify-center items-center">
            <img src="{{ $movie['poster_url'] }}" alt="Poster de {{ $movie['titulo'] }}" class="rounded-lg shadow-md">
        </div>

        <div class="flex flex-col ">
            <div class="col-span-2 flex flex-col justify-between bg-slate-400 p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Detalles Generales</h2>
                <ul class="mb-4 space
            <ul class="mb-4 space-y-2 text-gray-700">
                <li><strong>Año:</strong> {{ $movie['anho'] }}</li>
                <li><strong>Puntuación TMDB:</strong> {{ $movie['valoracion'] }}</li>
                <li><strong>Sinopsis:</strong> {{ $movie['resumen'] }}</li>
            </ul>
            <button class="bg-yellow-400 text-black font-bold py-2 px-4 rounded w-fit hover:bg-yellow-500">
                Crear Reseña
            </button>
        </div>
        </div>
    </div>

                <div class="col-span-2 flex flex-col justify-between bg-slate-400 p-4 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Detalles Adicionales</h2>
                    <ul class="mb-4 space-y-2 text-gray-700">
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




        <div class="col-span-3">
            <h2 class="text-2xl font-semibold mb-4">Reparto</h2>
            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($movie['reparto'] as $actor)
                    <li class="text-center">
                        <div class="foto">
                            <img src="{{ $actor['foto'] }}" alt="Foto de {{ $actor['nombre'] }}" class="rounded-full w-15 h-auto mx-auto mb-2">
                        </div>
                        <div class="text-gray-800 font-medium">
                            {{ $actor['nombre'] }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ $actor['personaje'] }}
                        </div>
                    </li>
                @endforeach
            </ul>
    </div>


</div>
@endsection
