@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    @include('components.hero')
    @include('components.about')
    @include('components.prices')
    @include('components.testimoni')
@endsection