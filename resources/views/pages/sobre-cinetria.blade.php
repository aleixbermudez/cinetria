@extends('layouts.layout')


@section('title', 'Sobre Cinetria')

@section('content')

    <div id="container">

        <div>
            @include('components.about-us')
        </div>
        <div class="pt-5">
            @include('components.team')
        </div>
        
    </div>

    
    
    
@endsection