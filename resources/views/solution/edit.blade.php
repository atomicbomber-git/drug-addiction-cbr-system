@extends('shared.layout')
@section('title', 'Sunting Solusi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Solusi
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"> <a href="{{ route('solution.index') }}"> Kelola Solusi </a> </li>
            <li class="breadcrumb-item active"> Sunting Solusi </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Solusi
        </div>
        <div class="card-body">
            <form action="{{ route('solution.update', $solution) }}" method="POST">
                @csrf
                <div class='form-group'>
                    <label for='content'> Isi: </label>
                
                    <textarea
                        id='content' name='content'
                        class='form-control {{ !$errors->has('content') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('content', $solution->content) }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('content') }}
                    </div>
                </div>

                <div class="mt-3 text-right">
                    <button class="btn btn-primary">
                        Perbarui Data
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection