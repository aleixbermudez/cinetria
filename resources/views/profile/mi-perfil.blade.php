@extends('layouts.layout')
@section('title', 'Mi perfil')

@section('content')

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Mi Perfil</h1>
    <div class="flex items-center space-x-4 mb-6">
        <img src="https://via.placeholder.com/100" alt="Foto de perfil" class="w-24 h-24 rounded-full shadow-md">
        <div>
            <h2 class="text-xl font-semibold text-gray-700">{{$user->name}}</h2>
            <p class="text-gray-500">{{$user->email}}</p>
        </div>
    </div>
    <div class="space-y-4">
    <div class="mt-6">
        <a href="{{ url('perfil/editar') }}" class="inline-block px-6 py-2 text-black bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md">
            Editar Perfil
        </a>
    </div>
</div>

@endsection