@extends('shared.layout')
@section('title', 'Sunting Kasus Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Kasus Baru
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"><a href="{{ route('unverified_case.index') }}"> Kelola Kasus Baru </a> </li>
            <li class="breadcrumb-item active"> Sunting Kasus Baru </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Kasus Baru
        </div>
        <div class="card-body">
            <form action="{{ route('unverified_case.update', $case) }}" method="POST">
                @csrf
                <h1 class="h4"> Gejala </h1>
                <hr>

                @foreach ($case->case_features as $case_feature)
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
                        @foreach(\App\CaseRecord::STAGES as $stage)
                        <option {{ old('stage', $case->stage) == $stage ? 'selected' : '' }} value='{{ $stage }}'> {{ $stage }} </option>
                        @endforeach
                        <option {{ old('stage', $case->stage) == NULL ? 'selected' : '' }} value=""> - </option>
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('stage') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='solution_id'> Solusi: </label>
                    <select name='solution_id' id='solution_id' class='form-control'>
                        @foreach($solutions as $solution)
                        <option {{ old('solution_id', $case->solution->id) == $solution->id ? 'selected' : '' }} value='{{ $solution->id }}'> {{ $solution->content }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('solution_id') }}
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