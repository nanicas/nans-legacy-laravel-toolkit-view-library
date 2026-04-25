<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('head')
    @yield('meta')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/sass/app.scss'])

    <link href="{{ asset($packaged_assets_prefix . '/css/layouts/app.css') }}" rel="stylesheet">

    @if (!empty($assets['css']))
        @foreach ($assets['css'] as $css)
            <link rel="stylesheet" href="{{ asset($css) }}">
            </link>
        @endforeach
    @endif

    @yield('css')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm" id="navbar-header">
            <div class="container">
                @yield('app_logo', View::make('components.app_logo'))

                @auth
                    @if ($template_config['frontend']['header']['search']['has'])
                        <div class="p-3">
                            <div class="container d-flex justify-content-end dropdown">
                                <div class="input-group position-relative">
                                    <input type="text" id="search-input" class="form-control"
                                        placeholder="{{ $template_config['frontend']['header']['search']['placeholder'] }}">
                                    <button class="btn btn-primary" id="search-button"
                                        data-route="{{ route(
                                            $template_config['frontend']['header']['search']['route'],
                                            $template_config['frontend']['header']['search']['route_params'],
                                        ) }}">
                                        <i class="bi bi-search"></i> <!-- Bootstrap Icons -->
                                    </button>
                                    <button class="btn btn-warning" id="clear-search-button">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <div id="search-dropdown">
                                    <ul class="dropdown-menu w-100" aria-labelledby="search-button"
                                        id="search-dropdown-menu">
                                        <li><span class="dropdown-item text-muted">Digite algo para buscar...</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                <div class="collapse navbar-collapse align-items-center d-flex justify-content-center">

                    @php $currentRouteName = Route::currentRouteName(); @endphp

                    @if (Route::has('site') && $currentRouteName != 'site')
                        <a class="text-decoration-none text-light" href="{{ route('site') }}">
                            <i class="bi bi-globe-americas"></i>
                        </a>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto ">
                        <!-- Authentication Links -->
                        @if (!Helper::isAnyGuardAuthenticated())
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('register', !empty($register_params) ? $register_params : []) }}">Registrar-se</a>
                                </li>
                            @endif
                        @else
                            @if ($currentRouteName == 'site')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                                </li>
                            @endif

                            <div class="nav-item dropdown text-end">
                                <a role="button" href="#" aria-expanded="false"
                                    class="nav-link d-block text-decoration-none dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-person-bounding-box align-middle me-2" style="font-size: 35px"></i>
                                    {{ Helper::getUserName(false) }}
                                </a>
                                <ul class="dropdown-menu text-small" data-popper-placement="bottom-start">
                                    @if ($template_config['frontend']['header']['navbar']['user']['has_profile'])
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route($template_config['frontend']['header']['navbar']['user']['profile_route'], Helper::getUser()->id) }}">
                                                <i class="bi bi-person-circle"></i> Perfil
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-door-closed"></i> Sair
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            {{-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Helper::getUserName(false) }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li> --}}
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">

                @if (!empty($app_flash_data))
                    @if (is_array($app_flash_data) && !empty($app_flash_data['message']))
                        <div class="flash-message">
                            @if (!empty($app_flash_data['wrapped']))
                                {!! $app_flash_data['message'] !!}
                            @else
                                @if (array_key_exists('status', $app_flash_data))
                                    @if ($app_flash_data['status'] === true)
                                        @include('components.messages.success', [
                                            'message' => $app_flash_data['message'],
                                        ])
                                    @else
                                        @include('components.messages.danger', [
                                            'message' => $app_flash_data['message'],
                                        ])
                                    @endif
                                @else
                                    <div class="alert alert-primary">
                                        {{ $app_flash_data['message'] }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                @endif

                <div id="top-message"></div>
            </div>

            @yield('content')

            <div class="container-fluid">
                <div id="bottom-message"></div>
            </div>
        </main>
    </div>

    <footer class="py-3 my-4 mb-0">
        @yield('footer')
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <!--            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>-->
        </ul>
        <p class="text-center text-muted mb-0">© {{ date('Y') }}</p>
    </footer>
</body>

@vite(['resources/js/app.js'])

<script type="text/javascript" src="{{ asset($packaged_assets_prefix . '/js/layouts/app.js') }}" defer></script>
<script type="text/javascript" src="{{ asset($packaged_assets_prefix . '/js/utils/helper.js') }}" defer></script>

@if (!empty($assets['js']))
    @foreach ($assets['js'] as $js)
        <script type="text/javascript" src="{{ asset($js) }}" defer></script>
    @endforeach
@endif

@yield('js')

</html>
