@extends('layouts.layout')


@section('title', 'Sobre Cinetria')

@section('content')

    <div id="container">
        @include('components.navbar')

        <div>
            @include('components.about-us')
        </div>
        <div class="pt-5">
            @include('components.team')
        </div>

        <div class="pt-20">
            @include('components.footer')
        </div>
        
    </div>

    
    
    
@endsection