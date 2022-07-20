<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar'?'rtl':'ltr' }}" lang="{{ app()->getLocale() }}"> 
<head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    @if( app()->getLocale() == 'en' )
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    @else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    @endif
    {{-- <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontEnd/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontEnd/slick/slick-theme.css') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
          $route = Route::current();
          $name = $route->getName();
          $prefix = $route->getPrefix();
    @endphp
    @if($name == 'frontEnd.index')
        @if(app()->getLocale() == 'ar' )
            <link rel="stylesheet" href="{{ asset('frontEnd/css/ar/style-index-page.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('frontEnd/css/style-index-page.css') }}">
        @endif
    @else
        @if(app()->getLocale() == 'ar' )
        <link rel="stylesheet" href="{{ asset('frontEnd/css/ar/style.css') }}">
        @else
        <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
        @endif
    @endif
</head>

<body class="body">
    <!-- menu section -->
    @include('frontEnd.layouts.welcomePageHeader')

    <!-- end menu section -->
    <!-- text & image section -->
    @if($prefix == '/customers'||$prefix == 'customers/ad')
    <section class="background-page10 position-relative py-5" style="background-image: url({{ asset('frontEnd/img/handsome-caucasian-bearded-freelancer-with-toothy-smile-sitting-office-late-night-using-tablet-surfing-internet-social-media-concept.png')}})">
        
        <div class="py-5">
            <div class="contract text-center">
                <h1>{{ trans('messages.frontEnd.welcome_back') }}</h1>
             
                <p>{{ auth()->user()->customers->full_name }}</p>
            </div>
        </div>
        <div class="position-absolute flower">
            <img src="{{asset('frontEnd/img/Group 55162.png')}}" alt="" width="260px">
        </div>
    </section>
    @endif
    
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