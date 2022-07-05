<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar'?'rtl':'ltr' }}" lang="{{ app()->getLocale() }}"> 

<head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontEnd/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontEnd/slick/slick-theme.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
          $route = Route::current();
        $name = $route->getName();

    @endphp
    @if($name == 'frontEnd.index')
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style-index-page.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
    @endif
</head>

<body class="body">
    <!-- menu section -->
    @include('frontEnd.layouts.welcomePageHeader')

    <!-- end menu section -->
    <!-- text & image section -->

    @yield('content')

    
    @include('frontEnd.layouts.footer')
    <!--JAVASCRIPT-->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type='text/javascript' src='{{ asset('frontEnd/js/jquery-3.6.0.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('frontEnd/js/bootstrap.min.js') }}'></script>
    <script type="text/javascript" src="{{ asset('frontEnd/slick/slick.min.js') }}"></script>

    @yield('scripts')

</body>

</html>