@extends('shared.layout')
@section('title', 'Tentang Saya')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-info'></i>
        Tentang Saya
    </h1>

    <div class="card">
        <div class="card-body">
           <dl>
                <dt> Nama: </dt>
                <dd> Dian Aulia Sari </dd>
                
                <dt> Tempat, Tanggal Lahir: </dt>
                <dd> Singkawang, 14 Maret 1995 </dd>
                
                <dt> Riwayat Pendidikan </dt>
                <dd> Teknik Informatika Universitas Tanjungpura </dd>

                <dt> E-Mail: </dt>
                <dd>
                    <a href="mailto:dianiyank14@gmail.com">
                        dianiyank14@gmail.com
                    </a>
                </dd>
           </dl>
        </div>
    </div>
</div>
@endsection