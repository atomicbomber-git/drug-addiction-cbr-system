@extends('shared.layout')
@section('title', 'Hasil Diagnosis Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-calculator'></i>
        Hasil Diagnosis Kasus
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"><a href="{{ route('unverified_case.guest_create') }}"> Diagnosis Kasus </a> </li>
            <li class="breadcrumb-item active"> Hasil Diagnosis Kasus </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-calculator"></i>
            Hasil Diagnosis Kasus
        </div>
        <div class="card-body">

            <h1 class="h4"> Gejala-Gejala Kasus </h1>
            <hr class="mt-0"/>

            @foreach ($case->case_features as $case_feature)
                <div>
                    @if ($case_feature->value)
                    <i class="fa fa-check text-success"></i>
                    @else
                    <i class="fa fa-times text-danger"></i>
                    @endif
                    {{ $case_feature->feature->description }}
                </div>
            @endforeach

            <h1 class="h4 mt-5"> Hasil Diagnosis </h1>
            <hr class="mt-0"/>

            <table class='table table-sm table-striped'>
                <thead class="thead thead-dark">
                     <tr>
                         <th> Tahapan </th>
                         <th> Solusi </th>
                         <th> Similaritas </th>
                     </tr>
                </thead>
                <tbody>
                     <tr>
                         <td> {{ $most_similar_case->stage }} </td>
                         <td> {{ $most_similar_case->solution->content }} </td>
                         <td> {{ $most_similar_case->similarity * 100 }}% </td>
                     </tr>
                </tbody>
             </table>
        </div>
    </div>
</div>
@endsection