<!-- resources/views/layouts/app.blade.php -->
<!doctype html>
@stack('scripts')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Theater Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/theater.css') }}">

    <style>
        /* Navbar'ı düzenle */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #C04060, #800020);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Kartlar */
        .card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2) !important;
        }

        /* Ana içerik */
        main.py-4 {
            min-height: calc(100vh - 80px);
        }

        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="theater-bg">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
         style="position: sticky; top: 0; z-index: 1050;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                THEATER TICKET
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn-theater-sm" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Giriş Yap
                                </a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item ms-2">
                                <a class="nav-link btn-theater-outline-sm" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Kayıt Ol
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- Dashboard Linki (Herkes için) -->
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home"></i> Ana Sayfa
                                </a>

                                <!-- Admin Paneli Linki (Sadece Adminler için) -->
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-user-shield"></i> Admin Paneli
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif

                                <!-- Çıkış Yap -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Çıkış Yap') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class=" navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(isset($breadcrumbs))
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                                @foreach($breadcrumbs as $crumb)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active" style="color: #6c757d; font-weight: 600;">
                                            {{ $crumb['title'] }}
                                        </li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $crumb['url'] }}" style="color: #800020; text-decoration: none; font-weight: 500;">
                                                {{ $crumb['title'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @else
                        <span style="color: #6c757d; font-weight: 500; font-size: 0.95rem;">
                            <i class="fas fa-home"></i> Ana Sayfa
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <main class="py-4">

        @yield('content')
    </main>
</div>

<!-- BOOTSTRAP 5 JS BUNDLE (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
