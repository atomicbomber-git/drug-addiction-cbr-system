@extends('shared.layout')
@section('title', 'Kelola Solusi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-comment-o'></i>
        Kelola Solusi
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> Sistem Diagnosis TPN </li>
            <li class="breadcrumb-item"> Kelola Solusi </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route('solution.create') }}" class="btn btn-dark btn-sm">
            Tambah Solusi Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-comment-o"></i>
            Kelola Solusi
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-striped'>
                    <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Isi </th>
                            <th class="text-center" style="width: 6rem"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solutions as $solution)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $solution->content }} </td>
                            <td class="text-center">
                                <a class="btn btn-dark btn-sm" href="{{ route('solution.edit', $solution) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action='{{ route('solution.delete', $solution) }}' method='POST' class='d-inline-block'>
                                    @csrf
                                    <button {{ $solution->cases_count > 0 ? 'disabled' : '' }} type='submit' class='btn btn-danger btn-sm'>
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