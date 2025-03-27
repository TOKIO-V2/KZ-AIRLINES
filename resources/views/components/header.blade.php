<header class="navbar">
    <nav class="navbar-container">
        <div class="left">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('img/logoKZ.png') }}" alt="Logo" class="logo-web">
            </a>
        </div>
        <div class="right login">
            <ul class="navbar-nav ms-auto">
                <div class="right login">
                    @guest
                        @if (Route::has('login') || Route::has('register'))
                            <div class="auth-links">
                                @if (Route::has('login'))
                                    <a class="menu-link auth-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="menu-link auth-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="dropdown">
                            <img src="{{ asset('img/icon.png') }}" alt="Profile" class="profile-pic">
                            <div class="dropdown-content">
                                @if(Auth::check() && !Auth::user()->isAdmin)
                                
                                @endif
                                @if(Auth::check() && Auth::user()->isAdmin)
                                    <a href="/listAircraftAdmin">Aviones</a>
                                    <a href="/flightList">Vuelos</a>
                                @endif
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </ul>
        </div>
    </nav>
</header>