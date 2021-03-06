<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">

            <span style="font-size: 0.9rem">
                {{ config('app.name') }}
            </span>

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">

                @if(($has_navbar ?? TRUE ))

                @if(!auth()->check() || session('mode-customer'))

                <li class='nav-item {{ Route::is('guest.home') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('guest.home') }}'>
                        <i class='fa fa-home'></i>
                        Home
                    </a>
                </li>

                <li class='nav-item {{ Route::is('unverified_case.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('unverified_case.guest_create') }}'>
                        <i class='fa fa-user-md'></i>
                        Konsultasi
                    </a>
                </li>

                <li class='nav-item {{ Route::is('guest.help') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('guest.help') }}'>
                        <i class='fa fa-question'></i>
                        Bantuan
                    </a>
                </li>

                <li class='nav-item {{ Route::is('guest.about') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('guest.about') }}'>
                        <i class='fa fa-info'></i>
                        Tentang Saya
                    </a>
                </li>

                @else
                @auth
                <li class='nav-item {{ Route::is('admin-home.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('admin-home.show') }}'>
                        <i class='fa fa-home'></i>
                        Home
                    </a>
                </li>

                <li class='nav-item {{ Route::is('base_case.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('base_case.index') }}'>
                        <i class='fa fa-list-alt'></i>
                        Basis Kasus
                    </a>
                </li>

                <li class='nav-item {{ Route::is('unverified_case.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('unverified_case.index') }}'>
                        <i class='fa fa-list'></i>
                        Kasus Baru
                    </a>
                </li>
                
                <li class='nav-item {{ Route::is('feature.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('feature.index') }}'>
                        <i class='fa fa-bars'></i>
                        Fitur
                    </a>
                </li>

                <li class='nav-item {{ Route::is('solution.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('solution.index') }}'>
                        <i class='fa fa-comment-o'></i>
                        Solusi
                    </a>
                </li>

                @endauth
                @endif
                @endif
            </div>

            @auth
            <a class="btn btn-light mr-2" href="{{ route('mode_switch') }}">
                @if(session('mode-customer'))
                Website Administrator
                @else
                Website Umum
                @endif
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger">
                    Log Out
                    <i class="fa fa-sign-out"></i>
                </button>
            </form>
            @endauth
        </div>
    </div>
</nav>