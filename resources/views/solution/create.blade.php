@extends('shared.layout')
@section('title', 'Tambah Solusi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Solusi
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Solusi
        </div>
        <div class="card-body">
            <form method='POST' action='{{ route('solution.store') }}'>
                @csrf
            
                <div class='form-group'>
                    <label for='content'> Isi: </label>
                
                    <textarea
                        id='content' name='content'
                        class='form-control {{ !$errors->has('content') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('content') }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('content') }}
                    </div>
                </div>

                <div class="mt-3 text-right">
                    <button class="btn btn-primary">
                        Tambah Solusi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection