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
    <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">
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
                    <li><i class="nav-ic ic-dashboard"></i><a href="{{ url('/') }}"> Dashboard</a></li>
                    <li><i class="nav-ic ic-user"></i><a href="{{ url('/users') }}"> Users</a></li>
                    <li><i class="nav-ic ic-message"></i><a href="{{ url('/messages') }}"> Messages</a></li>
                </ul>
            </div>
            <div class="main-container">
                <div class="main-header">
                    <div class="title"></div>
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

    <div class="modal fade" id="notification-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="notification-content">
                <div class="image-wrapper">
                    <img src="{{asset('img/ic_check_notification.png')}}" alt="">
                </div>
                <div class="text-content">
                    <div class="notification-title"></div>
                    <div class="notification-description"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
</body>
</html>
