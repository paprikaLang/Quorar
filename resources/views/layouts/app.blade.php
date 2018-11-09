<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : '' }}">
    <title>{{ config('app.name', 'Quorar') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script>
        @if(Auth::check())
            window.Quorar = {
                name: "{{Auth::user()->name}}",
                avatar:"{{Auth::user()->avatar}}"
            }
        @endif
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-default  navbar-expand-md" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header" style="font-size: 30px;">
                    <a class="navbar-link" href="{{ url('/') }}" style="text-decoration:none; margin-left: -100px;">
                        {{ config('app.name', 'Quorar') }}
                    </a>
                </div>

                <div>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right" style="font-size: 14px; margin-right: -100px;">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-right: 5px;">
                                   <strong> {{ Auth::user()->name }}</strong>
                                </a>

                                <ul class="dropdown-menu" style="margin-right: 10px;">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout  </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <div><a href="/">
                                <img width="45px;" src="{{Auth::user()->avatar}}" >
                            </a>
                            </div>

                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main role="main">
        <div id="app">
        <div class="container">
            @include('flash::message')
        </div>
        @yield('content')
        </div>
    </main>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('js')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
</body>
</html>
