@extends('shared.layout')
@section('title', 'Analisis Kasus Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-calculator'></i>
        Analisis Kasus Baru
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item"> <a href="{{ route('unverified_case.index') }}"> Kelola Kasus Baru </a> </li>
            <li class="breadcrumb-item active"> Analisis Kasus Baru </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-calculator"></i>
            Analisis Kasus Baru
        </div>
        <div class="card-body">

            <h1 class="h4"> Kasus Ini </h1>
            <hr class="mt-0"/>

            <div class="table-responsive">
                <table class='table table-sm table-striped'>
                    <thead class="thead thead-dark">
                        <tr>
                            <th> F1 </th>
                            <th> F2 </th>
                            <th> F3 </th>
                            <th> F4 </th>
                            <th> F5 </th>
                            <th> F6 </th>
                            <th> F7 </th>
                            <th> F8 </th>
                            <th> F9 </th>
                            <th> F10 </th>
                            <th> F11 </th>
                            <th> F12 </th>
                            <th> F13 </th>
                            <th> F14 </th>
                            <th> F15 </th>
                            <th> F16 </th>
                            <th> F17 </th>
                            <th> F18 </th>
                            <th> Tahapan </th>
                            <th> Solusi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($case->case_features as $case_feature)
                            <td> {{ $case_feature->value }} </td>
                            @endforeach
                            <td> {{ $case->stage }} </td>
                            <td> {{ $case->solution->content }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h1 class="h4 mt-5"> Basis Kasus Dengan Nilai Similaritas Tertinggi dengan Kasus Ini </h1>
            <hr class="mt-0"/>

            <div class="table-responsive">
                <table class='table table-sm table-striped'>
                    <thead class="thead thead-dark">
                         <tr>
                             <th> ID </th>
                             <th> F1 </th>
                             <th> F2 </th>
                             <th> F3 </th>
                             <th> F4 </th>
                             <th> F5 </th>
                             <th> F6 </th>
                             <th> F7 </th>
                             <th> F8 </th>
                             <th> F9 </th>
                             <th> F10 </th>
                             <th> F11 </th>
                             <th> F12 </th>
                             <th> F13 </th>
                             <th> F14 </th>
                             <th> F15 </th>
                             <th> F16 </th>
                             <th> F17 </th>
                             <th> F18 </th>
                             <th> Tahapan </th>
                             <th> Solusi </th>
                             <th> Similaritas </th>
                             <th> Jarak Euclidean </th>
                         </tr>
                    </thead>
                    <tbody>
                        @foreach ($most_similar_cases as $case)
                         <tr>
                             <td> {{ $case->id }} </td>
                             @foreach ($case->case_features as $case_feature)
                             <td> {{ $case_feature->value }} </td>
                             @endforeach
                             <td> {{ $case->stage }} </td>
                             <td> {{ $case->solution->content }} </td>
                             <td> {{ $case->similarity }} </td>
                             <td> {{ $case->distance }} </td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection