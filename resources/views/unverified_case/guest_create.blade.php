@extends('shared.layout')
@section('title', 'Diagnosis Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-user-md'></i>
        Diagnosis Kasus
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item active"> Konsultasi </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-user-md"></i>
            Silakan Lakukan Konsultasi
        </div>
        <div class="card-body">
            <form action="{{ route('unverified_case.guest_store') }}" method="POST">
                @csrf
                @foreach ($features as $feature)
                <div class='form-group'>
                    <span class="d-inline-block" style="width: 2rem">
                        F{{ $feature->id }}
                    </span>
                    <div class="custom-control custom-checkbox d-inline-block">
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

                @if($errors->has("features"))
                <div class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    {{ $errors->first("features") }}
                </div>
                @endif

                <div class="text-right">
                    <button class="btn btn-primary">
                        Lakukan Diagnosis
                    </button>
                </div>
           </form>
        </div>
    </div>
</div>
@endsection
