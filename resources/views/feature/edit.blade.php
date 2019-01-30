@extends('shared.layout')
@section('title', 'Sunting Fitur')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Fitur
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item"> <a href="{{ route('feature.index') }}"> Kelola Fitur </a> </li>
            <li class="breadcrumb-item active"> Sunting Fitur </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Fitur
        </div>
        <div class="card-body">
            <form action="{{ route('feature.update', $feature) }}" method="POST">
                @csrf
                <div class='form-group'>
                    <label for='description'> Deskripsi: </label>
                
                    <textarea
                        id='description' name='description'
                        class='form-control {{ !$errors->has('description') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('description', $feature->description) }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('description') }}
                    </div>
                </div>

                <div class="mt-3 text-right">
                    <button class="btn btn-primary">
                        Perbarui Data
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection