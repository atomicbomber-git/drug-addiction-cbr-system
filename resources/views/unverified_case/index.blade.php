@extends('shared.layout')
@section('title', 'Kelola Kasus Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list'></i>
        Kelola Kasus Baru
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Kelola Kasus Baru </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route('unverified_case.create') }}" class="btn btn-dark btn-sm form-delete-case">
            Tambah Kasus Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Kelola Kasus Baru
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-striped'>
                   <thead class="thead thead-dark">
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
                            <th class="text-center" style="width: 10rem"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($cases as $case)
                        <tr>
                            <td> {{ $cases->firstItem() + $loop->index }}. </td>
                            @foreach ($case->case_features as $case_feature)
                            <td> {{ $case_feature->value }} </td>
                            @endforeach
                            <td> {{ $case->stage }} </td>
                            <td> {{ $case->solution->content }} </td>
                            <td class="text-center">
                                <form action="{{ route('unverified_case.verify', $case) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                <a href="{{ route('unverified_case.retrieve', $case) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-calculator"></i>
                                </a>
                                <a href="{{ route('unverified_case.edit', $case) }}" class="btn btn-dark btn-sm">
                                    {{-- Sunting --}}
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action='{{ route('unverified_case.delete', $case) }}' method='POST' class='d-inline-block form-delete-case'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        {{-- Hapus --}}
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $cases->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.form-delete-case').each((i, form) => {
            $(form).on('submit', e => {
                e.preventDefault()

                swal({
                    title: "Konfirmasi Penghapusan",
                    text: "Apakah Anda yakin Anda hendak menghapus berkas ini?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(form).off('submit')
                            .submit()
                    }
                });
            })
        })
    })
</script>
@endsection