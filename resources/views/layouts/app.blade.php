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
            {{-- <a class="navbar-brand" href="{{ url('/') }}">
                 {{ config('app.name', 'Laravel') }}
             </a>--}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ورود') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('ثبت نام') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} {{ Auth::user()->lastName }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('خروج') }}
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

    <main>
        @yield('content')
    </main>
</div>

<script>

    function disableInputAcid(inputprocess, material, process, acidList) {
        if (inputprocess.checked) {
            acidList.forEach(element => {
                document.getElementById(material + ':' + process + ':' + element.id).style.display = 'flex';
                document.getElementById('label' + ':' + material + ':' + process + ':' + element.id).style.display= 'flex';
            });
        } else {
            acidList.forEach(element => {
                document.getElementById(material + ':' + process + ':' + element.id).style.display = 'none';
                document.getElementById('label' + ':' + material + ':' + process + ':' + element.id).style.display = 'none';
            });
        }
    }

    function disableInputMaterial(inputMaterial, productMaterial, Materialid) {
        if (inputMaterial.checked) {
            Materialid.forEach(element => {
                document.getElementById(productMaterial).disabled = false;
                console.log(element.id)
            });
        } else {
            Materialid.forEach(element => {
                document.getElementById(productMaterial).disabled = true;
                console.log(element.id)
            });
        }
    }

    function disableInputprocess(inputprocess, process, acidList) {
        if (inputprocess.checked) {
            acidList.forEach(element => {
                document.getElementById(process + ':' + element.id).style.display = 'flex';
                document.getElementById('label' + ':' + process + ':' + element.id).style.display = 'flex';
                console.log(process + ':' + element.id)
            });
        } else {
            acidList.forEach(element => {
                document.getElementById(process + ':' + element.id).style.display = 'none';
                document.getElementById('label' + ':' + process + ':' + element.id).style.display = 'none';
            });
        }
    }

    function disableInputPacks(inputpack, packId,packHidden, pack) {
        if (inputpack.checked) {
            pack.forEach(element => {
                document.getElementById(packId).disabled = false;
                document.getElementById(packHidden).disabled = false;
                /*document.getElementById(packId).disabled = false;*/
                console.log(element)
            });
        } else {
            pack.forEach(element => {
                document.getElementById(packId).disabled = true;
                document.getElementById(packHidden).disabled = true;
                console.log(element.name)
            });
        }
    }
</script>
</body>
</html>
