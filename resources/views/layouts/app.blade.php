<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="row w-100 m-0">
        @guest
            <div class="col-md-12 p-0">

        @else
            <div class="col-md-2 p-0 ">
                <div class="card  bg-white shadow-sm" style="min-height: 100vh">
                    <nav class="navbar navbar-expand-md navbar-light p-3 d-block">
                        <div class="w-100 mb-5">
                            <a class="navbar-brand " href="{{ url('/') }}">
                                <img src="{{ asset('/assets/images/UO_logo.png') }}" alt="Logo">
                                {{-- {{ config('app.name', 'Laravel') }} --}}
                            </a>
                        </div>
                        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav me-auto w-100" style="display: block">
                                <li class="nav-item d-flex w-100 mt-4 h4">
                                    <img src="{{ asset('/assets/images/company.svg') }}" width="30" alt="company_logo">
                                    <a class="nav-link ms-3" href="{{ route('companies.index') }}">{{ __('Company') }}</a>
                                </li>
                                <li class="nav-item d-flex w-100 mt-4 h4">
                                    <img src="{{ asset('/assets/images/user.svg') }}" width="30" alt="user_logo">
                                    <a class="nav-link ms-3" href="#">{{ __('Users') }}</a>
                                </li>
                                <li class="nav-item d-flex w-100 mt-4 h4">
                                    <img src="{{ asset('/assets/images/ticket.svg') }}" width="30" alt="ticket_logo">
                                    <a class="nav-link ms-3" href="{{ route('tickets.index') }}">{{ __('Tickets') }}</a>
                                </li>
                                <li class="nav-item d-flex w-100 mt-4 h4">
                                    <img src="{{ asset('/assets/images/logout.svg') }}" width="30" alt="logout_logo">
                                    <a class="nav-link ms-3" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

            </div>
            <div class="col-md-10 p-0">
        @endguest
            <div id="app">
                @guest
                @else
                   <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm text-light">
                        <div class="container">
                            <a class="navbar-brand text-light" href="{{ url('/') }}">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="#">{{ Auth::user()->name }}</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @endguest

                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>
