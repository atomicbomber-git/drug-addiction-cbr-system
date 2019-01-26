@extends('shared.layout')
@section('title', 'Kelola Basis Kasus')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list-alt'></i>
        Kelola Basis Kasus
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item active"> Kelola Basis Kasus </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route('base_case.create') }}" class="btn btn-dark btn-sm">
            Tambah Basis Kasus Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list-alt"></i>
            Kelola Basis Kasus
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-striped'>
                   <thead class='thead thead-dark'>
                        <tr>
                            <th> # </th>
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
                            <th> Saran </th>
                            <th class="text-center" style="width: 10rem"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($base_cases as $base_case)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            @foreach ($base_case->case_features as $case_feature)
                            <td> {{ $case_feature->value }} </td>
                            @endforeach
                            <td> {{ $base_case->stage }} </td>
                            <td> {{ $base_case->solution }} </td>
                            <td> {{ $base_case->recommendation }} </td>
                            <td class="text-center">
                                <form action='{{ route('base_case.delete', $base_case) }}' method='POST' class='d-inline-block'>
                                    <a href="{{ route('base_case.edit', $base_case) }}" class="btn btn-dark btn-sm">
                                        Sunting
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        Hapus
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
@endsection