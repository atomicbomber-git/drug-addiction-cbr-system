@extends('shared.layout')
@section('title', 'Home')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-home'></i>
        Home
    </h1>

    <img src="{{ asset("home.jpg") }}" alt="Gambar Ilustrasi Narkoba">
</div>

@endsection