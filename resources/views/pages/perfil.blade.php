@extends('layouts.layout')

@section('title', 'Tu perfil')

@section('content')
    {{Auth::user()->name}}
@endsection