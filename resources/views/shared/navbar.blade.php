<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href=""> {{ config('app.name') }} </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">
                <li class='nav-item {{ Route::is('base_case.*') ? 'active' : '' }}'>
                    <a class='nav-link' href='{{ route('base_case.index') }}'>
                        <i class='fa fa-list-alt'></i>
                        Basis Kasus
                    </a>
                </li>
            </div>

            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger">
                    Log Out
                    <i class="fa fa-sign-out"></i>
                </button>
            </form>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="btn btn-primary">
                Log In
                <i class="fa fa-sign-in"></i>
            </a>
            @endguest
        </div>
    </div>
</nav>