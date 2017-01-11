<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/lforums/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/lforums/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/lforums/forums.css">
  @yield('styles')
  @yield('scripts')
</head>
<body>
<header class="navbar navbar-default navbar-static-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse"
              data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Laravel Forums</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="">Index</a></li>
        <li><a href="{{ route('forums.index') }}">{{ _('Forums') }}</a></li>
      </ul>
      @if (Auth::check())
        <div id="nav-profile" class="navbar-right">
          <i class="fa fa-bell nav-search"></i>
          <i class="fa fa-search nav-search" id="nav-search-icon"></i>
          @if (file_exists(Auth::user()->avatar))
            <img src="{{ Auth::user()->avatar }}" alt="" class="forum-avatar">
          @endif
          <div id="nav-profile-links">
            <a href="{{ route('users.show', ['user' => Auth::user()->slug]) }}">
              {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
            </a>
            <br>
          </div>
        </div>
      @else
        <ul class="nav navbar-right navbar-nav">
          @if (Auth::guest())
            <li><a href="{{ route('login') }}">{{ _('Login') }}</a></li>
            <li><a href="{{ route('register') }}">{{ _('Register') }}</a></li>
          @else
            <li><a href="{{ route('logout') }}">{{ _('Logout') }}</a></li>
          @endif
        </ul>
      @endif
    </div>
  </div>
  <div id="breadcrumbs">
    <div class="container">
      @yield('breadcrumbs')
    </div>
  </div>
</header>
<div class="container">
  {!! Session::get('message') !!}
  @yield('content')
</div>
<hr/>
<div class="container">
  <div class="pull-left"
       style="padding-top: 10px">{{ _('Laravel Forums') }}</div>
  <ul class="nav nav-pills pull-left">
    @if (\Auth::check())
      <li>
        <a href="{{ url('/logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
          Logout
        </a>

        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    @endif
  </ul>
</div>
</body>
</html>
