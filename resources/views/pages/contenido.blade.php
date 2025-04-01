@extends('layouts.layout')


@section('title', ucfirst($tipo))

@section('content')


    <div id="container flex justify-center items-center">
        @include('components.navbar')
        @include('components.portada')
        @include('components.sliders')
        <div class="pt-20">
            @include('components.footer')
        </div>
    </div>
    
    
@endsection