@extends('layouts.admin')


@section('title', 'Admin')

@section('content')
    <div class="lg:ps-96 m-5">
        @include('components.dashboard.resenhas-table')
    </div>
    

@endsection