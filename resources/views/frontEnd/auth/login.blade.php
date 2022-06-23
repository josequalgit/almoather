<!DOCTYPE html>
<html>
  <head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap && Css -->
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
  </head>
  <!-- All Images In Regular Size Are Hidden For Responsive Size (600 / 990) -->

  <body class="body">
    <!-- menu section -->
   
      <!-- end menu section -->
     <section class="background-page5 min-height-100 position-relative d-flex align-items-center">
         <div class="container">
            <div class="row">
                <div class="login text-center p-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12 text-login text-left">
                                <h1>{{ $data?->title->{app()->getlocale()} }}</h1>
                                <p>
                                    {{ $data?->description->{app()->getlocale()} }}
                                </p>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="circle-images d-flex">
                                        <div class="circle-img"><img src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt=""></div>
                                        <div class="circle-img"><img src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt=""></div>
                                        <div class="circle-img"><img src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt=""></div>
                                        <div class="circle-img"><img src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt=""></div>
                                        <div class="circle-img"><img src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt=""></div>
                                    </div>
                                    <p class="ps-4 m-0">Join 60.000 + users</p>
                                </div>
                            </div>
                            <img class="arrow-img" src="{{ asset('frontEnd/img/Group 50667.png') }}" alt="">
                            <div class="col-md-6 col-12 text-center">
                                <div>
                                    <div class="title">
                                        <div class="icon">
                                           <img src="{{ asset('frontEnd/img/logo.png') }}" width="150px" height="150px" alt="">
                                        </div>
                                        <h3>Welcome Back</h3>
                                        <span>Enter the required data</span>
                                    </div>
                                    <form method="POST" action="{{ route('auth.login_submit') }}" class="form mt-2"> 
                                        @csrf
                                        <div class="form-group mb-50">
                                            <input id="email" name="email" type="email" class="form-control"  autocomplete="email" autofocus placeholder="Phone Number or Email address">
                                             
                                          </div>
                                          <div class="form-group">
                                            <input id="password" type="password" name="password" class="form-control" name="password"  autocomplete="current-password" placeholder="Password">
                                          
                                          </div>
                                        <div class="extra mt-3">
                                            <div class="forget">
                                                <a href="#">Forgot Password ?</a>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-none login-button">Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
       
     </section>
 
 
      <!-- Footer -->
     
      <!-- End Footer -->
     <!--JAVASCRIPT-->
     @include('sweetalert::alert')

     <script type='text/javascript' src='{{ asset('frontEnd/js/jquery-3.6.0.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/bootstrap.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/all.min.js') }}'></script>
     <!--End JAVASCRIPT-->

 </body>
</html>