<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Upmood CMS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        var base_url = "{{url('/')}}/";
    </script>
</head>
<body>
    @if(Auth::check())
        <div id="app">
            <div class="sidenav">
                <div class="upmood-logo"></div>
                <ul>
                    <li><i class="nav-ic ic-dashboard"></i><a href="javascript:;"> Dashboard</a></li>
                    <li><i class="nav-ic ic-user"></i><a href="javascript:;"> Users</a></li>
                    <li><i class="nav-ic ic-message"></i><a href="javascript:;"> Messages</a></li>
                </ul>
            </div>
            <div class="main-container">
                <div class="main-header">
                    <div class="title"><i class="header-ic ic-dashboard-green"></i>Dashboard</div>
                    <div class="header-right">
                        <div class="notification">
                            <i class="nav-ic ic-notification"></i>
                            <div class="notification-count">10</div>
                        </div>
                        <div class="profile"><a class="logout-link" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{ asset('img/profile-avatar.png') }}" alt=""></a></div>
                        

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    @else
        <div id="app">
            @yield('content')
        </div>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollbar.min.js') }}"></script>
</body>
</html>
