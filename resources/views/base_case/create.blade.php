@extends('shared.layout')
@section('title', 'Tambah Basis Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Basis Kasus
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"> <a href="{{ route('base_case.index') }}"> Kelola Basis Kasus </a> </li>
            <li class="breadcrumb-item active"> Tambah Basis Kasus </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Basis Kasus
        </div>
        <div class="card-body">
            
            <form method='POST' action='{{ route('base_case.store') }}'>
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

                <h1 class="h4 mt-5"> Diagnosa </h1>
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
                    <label for='solution_id'> Solusi: </label>
                    <select name='solution_id' id='solution_id' class='form-control'>
                        @foreach($solutions as $solution)
                        <option {{ old('solution_id') !== $solution->id ?: 'selected' }} value='{{ $solution->id }}'> {{ $solution->content }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('solution_id') }}
                    </div>
                </div>

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