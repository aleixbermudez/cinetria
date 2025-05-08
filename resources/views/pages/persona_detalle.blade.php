@extends('layouts.layout')

@section('title', $persona['nombre'] ?? 'Detalle de la Persona')
<div id="container flex justify-center items-center w-full">
        @include('components.navbar')

            @include('components.buscador')

@section('content')
    <div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1 flex justify-center">
                @if ($persona['foto_perfil'])
                    <img src="{{ $persona['foto_perfil'] }}" alt="Foto de {{ $persona['nombre'] }}" class="rounded-md w-full h-auto">
                @else
                    <div class="w-48 h-72 bg-gray-200 rounded-md flex items-center justify-center">
                        <span class="text-gray-500">No hay foto disponible</span>
                    </div>
                @endif
            </div>
            <div class="md:col-span-2">
                <h2 class="text-2xl font-semibold mb-4">{{ $persona['nombre'] }}</h2>
                <p class="text-gray-600 mb-2">
                    @php
                        if($persona['conocido_por_departamento'] == 'Acting'){
                            $persona['conocido_por_departamento'] = 'Actor/Actriz';
                        } elseif($persona['conocido_por_departamento'] == 'Directing'){
                            $persona['conocido_por_departamento'] = 'Director/Directora';
                        } elseif($persona['conocido_por_departamento'] == 'Production'){
                            $persona['conocido_por_departamento'] = 'Producción';
                        } elseif($persona['conocido_por_departamento'] == 'Writing'){
                            $persona['conocido_por_departamento'] = 'Escritor/Escritora';
                        } elseif($persona['conocido_por_departamento'] == 'Sound'){
                            $persona['conocido_por_departamento'] = 'Sonido';
                        }
                    @endphp
                    <span class="font-semibold">Conocido por:</span> {{ $persona['conocido_por_departamento'] ?? 'Desconocido' }}
                </p>
                @if ($persona['fecha_nacimiento'])
                    <p class="text-gray-600 mb-2">
                        <span class="font-semibold">Fecha de Nacimiento:</span> {{ $persona['fecha_nacimiento'] }}
                    </p>
                @endif
                @if ($persona['lugar_nacimiento'])
                    <p class="text-gray-600 mb-2">
                        <span class="font-semibold">Lugar de Nacimiento:</span> {{ $persona['lugar_nacimiento'] }}
                    </p>
                @endif
                @if ($persona['biografia'])
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-2">Biografía</h3>
                        <p class="text-gray-700">{{ $persona['biografia'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if (!empty($persona['peliculas_series']))
            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-4">Filmografía Destacada</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($persona['peliculas_series'] as $trabajo)
                        <div class="bg-gray-100 rounded-md shadow-sm p-4">
                            @if ($trabajo['poster_url'])
                                <a href="/{{$trabajo['tipo']}}/{{$trabajo['id']}}">
                                    <img src="{{ $trabajo['poster_url'] }}" alt="{{ $trabajo['titulo'] }}" class="rounded-md w-full h-auto mb-2">
                                </a>
                            @else
                                <div class="w-full h-32 bg-gray-200 rounded-md flex items-center justify-center mb-2">
                                    <span class="text-gray-500 text-sm">No hay póster</span>
                                </div>
                            @endif
                            <h5 class="text-sm font-semibold">{{ $trabajo['titulo'] }}</h5>
                            @if ($trabajo['personaje'])
                                <p class="text-xs text-gray-500 italic">como {{ $trabajo['personaje'] }}</p>
                            @endif
                            @if ($trabajo['fecha'])
                                <p class="text-xs text-gray-500">({{ substr($trabajo['fecha'], 0, 4) }})</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    @include('components.footer')
@endsection