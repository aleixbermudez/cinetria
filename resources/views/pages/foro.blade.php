@extends('layouts.layout')


@section('title', 'Foro')

@section('content')

    <div id="container flex justify-center items-center w-full">
        @include('components.navbar')
        <div class="pt-20">
            @include('components.footer')
        </div>
    </div>
    
    
@endsection