@extends('shared.layout')
@section('title', 'Sunting Basis Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Basis Kasus
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"><a href="{{ route('base_case.index') }}"> Kelola Basis Kasus </a> </li>
            <li class="breadcrumb-item active"> Sunting Basis Kasus </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Basis Kasus
        </div>
        <div class="card-body">
            <form action="{{ route('base_case.update', $base_case) }}" method="POST">
                @csrf
                <h1 class="h4"> Gejala </h1>
                <hr>

                @foreach ($base_case->case_features as $case_feature)
                <div class='form-group'>
                    <div class="custom-control custom-checkbox">
                        <input
                            value="1"
                            {{ $case_feature->value ? 'checked' : '' }}
                            name="features[{{ $loop->iteration }}][value]" type="checkbox" class="custom-control-input" id="value-{{ $case_feature->feature_id }}">
                        
                        <input type="hidden" name="features[{{ $loop->iteration }}][feature_id] }}" value="{{ $case_feature->feature_id }}">
                        <label class="custom-control-label" for="value-{{ $case_feature->feature_id }}">
                            {{ $case_feature->feature->description }}
                        </label>
                    </div>
                </div>
                @endforeach

                <h1 class="h4 mt-5"> Diagnosa </h1>
                <hr>

                <div class='form-group'>
                    <label for='stage'> Tahapan: </label>
                    <select name='stage' id='stage' class='form-control'>
                        @foreach(['Ringan', 'Sedang', 'Berat'] as $stage)
                        <option {{ old('stage', $base_case->stage) == $stage ? 'selected' : '' }} value='{{ $stage }}'> {{ $stage }} </option>
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
                        >{{ old('solution', $base_case->solution) }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('solution') }}
                    </div>
                </div>

                <div class="form-group text-right">
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