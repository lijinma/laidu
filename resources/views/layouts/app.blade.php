<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" sizes="192x192" href="/images/ico.png" />
    <link rel="shortcut icon" href="/images/ico.png" type="image/png" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{--<link href="/css/app.css" rel="stylesheet">--}}
<!-- Styles -->
    {{--<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/custom.css?1492329636" rel="stylesheet">
    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav">
                        @if (Auth::user())
                        <li class="{{ Request::is('search')? 'active': '' }}">
                            <a href="{{ url('/search') }}"><i class="fa fa-search" aria-hidden="true"></i>
                                搜索</a>
                        </li>
                        <li class="{{ Request::is('books/create')? 'active': '' }}">
                            <a href="{{ url('/books/create') }}" class=""><i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                上传新书</a>
                        </li>
                        <li class="{{ Request::is('books/public')? 'active': '' }}">
                            <a href="{{ url('/books/public') }}"><i class="fa fa-book" aria-hidden="true"></i>
                                免费书籍</a>
                        </li>
                        <li class="{{ Request::is('books/wechat')? 'active': '' }}">
                            <a href="{{ url('/books/wechat') }}"><i class="fa fa-book" aria-hidden="true"></i>
                                公众号</a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ url('/books/all') }}">全部书籍</a>--}}
                        {{--</li>--}}
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="{{ Request::is('users/plans')? 'active': '' }}">
                            <a href="{{ url('/users/plans') }}"><i class="fa fa-users" aria-hidden="true"></i>
                                会员服务</a>
                        </li>
                        @if (Auth::user() && Auth::user()->isAdmin())
                            <li class="{{ Request::is('admin')? 'active': '' }}">
                                <a href="{{ url('/admin') }}">管理会员</a>
                            </li>
                        @endif
                        @if (Auth::guest())
                            <li class="{{ Request::is('login')? 'active': '' }}">
                                <a href="{{ url('/login') }}">登录</a>
                            </li>
                            <li class="{{ Request::is('register')? 'active': '' }}">
                                <a href="{{ url('/register') }}">注册</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} [{{ Auth::user()->getVipText() }}]<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->is_vip)
                                        <li>
                                            <a href="javascript:void(0)">
                                                会员截止于：{{ date('Y-m-d', strtotime(\Auth::user()->expired_in)) }}
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="https://jinshuju.net/f/vyuAg1" target="_blank">
                                            问题反馈
                                        </a>
                                    </li>
                                        {{--<li>--}}
                                            {{--<a href="/about">--}}
                                                {{--关于「来读」--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
        @yield('content')
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <hr>
                        <a href="/users/plans" class="btn btn-default">加入年费会员</a>
                        <h4>©2017 来读 </h4>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @yield('js')
    @include('layouts.partials.tongji')
</body>
</html>
