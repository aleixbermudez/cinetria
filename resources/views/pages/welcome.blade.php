@extends('layouts.layout')


@section('title', 'Cinetria')

@section('content')

    <div id="container">
        <div class="pt-5 ">
            @include('components.hero-home')
        </div>
        <div class="pt-5">
            @include('components.hero-section-info')
        </div>
        <div class="pt-5">
            @include('components.icon-section')
        </div>
        <div class="pt-5">
            @include('components.subscribe')
        </div>
        
    </div>

    
    
    
@endsection