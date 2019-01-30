@extends('shared.layout')
@section('title', 'Diagnosa Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-user-md'></i>
        Diagnosa Kasus
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
            Konsultasi
        </div>
        <div class="card-body">
            <form action="{{ route('unverified_case.guest_store') }}" method="POST">
                @csrf
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

                <div class="text-right">
                    <button class="btn btn-primary">
                        Lakukan Diagnosa
                    </button>
                </div>
           </form>
        </div>
    </div>
</div>
@endsection