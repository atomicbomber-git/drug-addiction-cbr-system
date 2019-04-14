@extends('shared.layout')
@section('title', 'Selamat Datang Admin')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-user'></i>
        Selamat Datang Admin
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-info"></i>
            Info
        </div>
        <div class="card-body">
            <ul>
                <li> Basis Kasus: Data kasus pengguna narkoba yang tersimpan di basis data. </li>
                <li> Kasus Baru: Data kasus dari konsultasi pengguna narkoba. </li>
                <li> Fitur: Data ciri-ciri pengguna narkoba. </li>
                <li> Solusi: Data solusi berdasarkan tahapan pengguna narkoba </li>
            </ul>
        </div>
    </div>
</div>
@endsection