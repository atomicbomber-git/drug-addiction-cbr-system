@extends('shared.layout')
@section('title', 'Kelola Fitur')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-bar'></i>
        Kelola Fitur
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Kelola Fitur </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-bar"></i>
            Kelola Fitur
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-striped'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Deskripsi </th>
                            <th> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($features as $feature)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $feature->description }} </td>
                            <td>
                                <a href="{{ route('feature.edit', $feature) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
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