<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ config('app.name') }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/turbolinks.js') }}"></script>
</head>
<body>
    @include('shared.navbar')

    <div style="min-height: 80vh">
        @yield('content')
    </div>

    <div class="bg-dark text-light">
        <div class="container py-4 text-center">
            © {{ now()->format('Y') }} - {{ config('app.name') }}
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>]
    @yield('scripts')
</body>
</html>
