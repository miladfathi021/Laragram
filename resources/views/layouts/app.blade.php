<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laragram') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar">
        <div class="container">
            <div class="flex items-center justify-between">
                <a class="navbar__brand w-1/4" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="laragram">
                </a>
                @if(auth()->user())
                    <div class="w-2/4">
                        <form action="" class="relative w-full">
                            <div class="form-group" style="margin-bottom: 0;">
                                <input type="text" class="input" name="search" placeholder="Search">
                            </div>
                            <div class="form-group absolute" style="top: 50%; right: 8px; transform: translateY(-50%);">
                                <button>
                                    <i class="fas fa-search text-gray-800 bg-white text-2xl pl-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            <!-- Right Side Of Navbar -->
                <ul class="navbar__nav flex justify-end">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item flex">
                            <a id="navbarDropdown" class="mr-3" href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="flex items-center" aria-labelledby="navbarDropdown">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if (auth()->user())
        <div class="w-full bg-gray-200">
            <div class="container">
                <div class="h-16 flex justify-around items-center">
                    <p><a class="px-2 py-4" href="#">Follow Requests <span class="text-white bg-red-600 text-sm w-auto h-auto px-2 py-1 inline-block text-center rounded-full">2</span></a></p>
                    <p><a class="px-2 py-4" href="#">Followers <span class="text-white bg-gray-500 text-sm w-auto h-auto px-2 py-1 inline-block text-center rounded-full">12225</span></a></p>
                    <p><a class="px-2 py-4" href="#">Following <span class="text-white bg-gray-500 text-sm w-auto h-auto px-2 py-1 inline-block text-center rounded-full">32</span></a></p>
                    <p><a class="px-2 py-4" href="#">Explore</a></p>
                    <p><a class="px-2 py-4" href="#">Notifications <span class="text-white bg-red-600 text-sm w-auto h-auto px-2 py-1 inline-block text-center rounded-full">16</span></a></p>
                </div>
            </div>
        </div>
    @endif

    <main class="py-2">
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
