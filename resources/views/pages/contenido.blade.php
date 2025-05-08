@extends('layouts.layout')


@section('title', ucfirst($tipo))

@section('content')


    <div id="container flex justify-center items-center w-full">
        <div class="mx-auto">
            @include('components.portada')
        </div>
        @include('components.sliders')
        @include('components.filtrador_generos')
    </div>
    
    
@endsection