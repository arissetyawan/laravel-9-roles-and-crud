<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ENV('APP_NAME') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ ENV('APP_NAME') }}
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ ENV('APP_NAME') }}
                </a>
                @endguest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('ex-register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} ({{Auth::user()->get_role_name()}})
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                @if(Auth::user()->get_role_name()=='pelapor' || Auth::user()->get_role_name()=='petugas')
                                  <a class="dropdown-item" href="{{ route('ticket') }}">
                                        {{ __('Tiket') }}
                                  </a>
                                @endif
                                @if(Auth::user()->get_role_name()=='admin')
                                  <a class="dropdown-item" href="{{ route('ticket') }}">
                                        {{ __('Tiket') }}
                                  </a>
                                    <a class="dropdown-item" href="{{ route('category') }}">
                                        {{ __('Kategori') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('priority') }}">
                                        {{ __('Prioritas') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('role') }}">
                                        {{ __('Peran') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('user') }}">
                                        {{ __('Pengguna') }}
                                    </a>
                                @endif

                                   <a class="dropdown-item" href="{{ route('profile/edit') }}">
                                        {{ __('Seting') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @include('sweetalert::alert')
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
