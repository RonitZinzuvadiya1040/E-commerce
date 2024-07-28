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

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Yajra Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/profile.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="#">Multi Auth</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                id="navbar-toggler">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @php
                        $user = Auth::user();
                    @endphp

                    @if (Auth::check() && $user->type === 'admin')
                        <li class="nav-item {{ request()->routeIs('admin.product.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.product.index') }}">Manage Products</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.category.index') }}">Manage Categories</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.brand.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.brand.index') }}">Manage Brands</a>
                        </li>
                    @endif

                    @if (Auth::check() && $user->type === 'user')
                        @foreach ($categories as $category)
                            @if ($category->children->isEmpty())
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ $category->name }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#"
                                        id="navbarDropdown{{ $category->id }}" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        {{ $category->name }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $category->id }}">
                                        @foreach ($category->children as $child)
                                            <a class="dropdown-item" href="#">{{ $child->name }}</a>
                                            @if ($child->children->isNotEmpty())
                                                <div class="dropdown-divider"></div>
                                                <div class="dropdown-menu">
                                                    @foreach ($child->children as $grandchild)
                                                        <a class="dropdown-item"
                                                            href="#">{{ $grandchild->name }}</a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    @endif

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item {{ request()->routeIs('register') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @php
                                    $user = Auth::user();
                                    $profileRoute = match ($user->type) {
                                        'admin' => route('admin.profile'),
                                        'manager' => route('manager.profile'),
                                        default => route('user.profile'),
                                    };
                                @endphp

                                <a class="dropdown-item" href="{{ $profileRoute }}">
                                    {{ __('Profile') }}
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
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    document.getElementById('navbar-toggler').click();
                }
            });
        });
    </script>
</body>

</html>
