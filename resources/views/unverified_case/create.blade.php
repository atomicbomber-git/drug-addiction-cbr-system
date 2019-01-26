@extends('shared.layout')
@section('title', 'Tambah Kasus Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Kasus Baru
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"> <a href="{{ route('unverified_case.index') }}"> Kelola Kasus Baru </a> </li>
            <li class="breadcrumb-item active"> Tambah Kasus Baru </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Kasus Baru
        </div>
        <div class="card-body">
            
            <form method='POST' action='{{ route('unverified_case.store') }}'>
                @csrf
                <h1 class="h4"> Gejala </h1>
                <hr>
            
                @foreach ($features as $feature)
                <div class='form-group'>
                    <div class="custom-control custom-checkbox">
                        <input
                            value="1"
                            {{ empty(old('features')[$loop->iteration]['value']) ? '' : 'checked' }}
                            name="features[{{ $loop->iteration }}][value]" type="checkbox" class="custom-control-input" id="value-{{ $feature->id }}">
                        
                        <input type="hidden" name="features[{{ $loop->iteration }}][id] }}" value="{{ $feature->id }}">
                        <label class="custom-control-label" for="value-{{ $feature->id }}">
                            {{ $feature->description }}
                        </label>
                    </div>
                </div>
                @endforeach

                {{-- <h1 class="h4 mt-5"> Diagnosa </h1>
                <hr>

                <div class='form-group'>
                    <label for='stage'> Tahapan: </label>
                    <select name='stage' id='stage' class='form-control'>
                        @foreach(\App\CaseRecord::STAGES as $stage)
                        <option value='{{ $stage }}'> {{ $stage }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('stage') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='solution'> Solusi: </label>
                
                    <textarea
                        id='solution' name='solution'
                        class='form-control {{ !$errors->has('solution') ?: 'is-invalid' }}'
                        col='30' row='6'
                        placeholder="Solusi"
                        ></textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('solution') }}
                    </div>
                </div> --}}

                <div class="form-group text-right">
                    <button class="btn btn-primary">
                        Tambah Data
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            
            </form>
        </div>
    </div>
</div>
@endsection