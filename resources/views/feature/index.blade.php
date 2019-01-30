@extends('shared.layout')
@section('title', 'Daftar Fitur')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-bar'></i>
        Daftar Fitur
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Daftar Fitur </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-bar"></i>
            Daftar Fitur
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-striped'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> Kode </th>
                            <th> Deskripsi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($features as $feature)
                        <tr>
                            <td> F{{ $feature->id }} </td>
                            <td> {{ $feature->description }} </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection