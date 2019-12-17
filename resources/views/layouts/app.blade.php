<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- User global access -->
    <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-brand-white">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-brand-greenish shadow-sm">
            <div class="container-fluid pl-4 pr-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-fluid" src="{{ asset('./images/logo.png') }}" alt="Main Solution for Real Estate logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav  ml-auto">

                        <li class="nav-item">
                            <a class="nav-link text-brand-grey" href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-brand-grey" href="{{ route('propertyList') }}">{{ __('Properties') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-brand-grey" href="#">{{ __('Services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-brand-grey" href="#">{{ __('About us') }}</a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item" style="border-left: 1px solid rgba(255,255,255,0.2) !important">
                                <a class="nav-link text-brand-grey" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-brand-grey" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown" style="border-left: 1px solid rgba(255, 255, 255, 0.2) !important">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} @if(auth()->user()->is_admin === 1)(Admin) @endif <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-brand-greenish" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('self_service.index') }}">
                                        {{ __('Self-service') }}
                                    </a>

                                    @if(auth()->user()->is_admin === 1)
                                    <a class="dropdown-item" href="{{ route('admin-dashboard') }}">
                                        {{ __('Admin Dashboard') }}
                                    </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest


                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>

        <v-footer></v-footer>

    </div>

</body>

</html>
