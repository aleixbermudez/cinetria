@extends('layouts.layout')

@section('title', $movie['titulo'])
<div id="container flex justify-center items-center w-full">
        @include('components.navbar')
        <div class="container mx-auto">
            @include('components.buscador')
        </div>
@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex">
        <div>
            <img src="{{ $movie['poster_url'] }}" alt="Poster de {{ $movie['titulo'] }}" class="rounded-lg shadow-md">
        </div>
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold mb-6 text-center">{{ $movie['titulo'] }}</h1>
            <div class="col-span-2 flex flex-col justify-between">
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Imagen principal --}}
        

        {{-- Detalles generales --}}
        

        {{-- Reparto --}}
        <div class="col-span-3">
            <h2 class="text-2xl font-semibold mb-4">Reparto</h2>
            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($movie['reparto'] as $actor)
                    <li class="text-center">
                        <div class="text-gray-800 font-medium">{{ $actor['nombre'] }}</div>
                        <div class="text-gray-600 text-sm">{{ $actor['personaje'] }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


</div>
@endsection
