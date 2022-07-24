<!DOCTYPE html>
<html  dir="{{ app()->getLocale() == 'ar'?'rtl':'ltr' }}" lang="{{ app()->getLocale() }}">
  <head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap && Css -->
    
    @if( app()->getLocale() == 'en' )
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    @else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    @endif

    @if(app()->getLocale() == 'ar' )
    <link rel="stylesheet" href="{{ asset('frontEnd/css/ar/style.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
    
  </head>
  <!-- All Images In Regular Size Are Hidden For Responsive Size (600 / 990) -->
  <body class="body">
    <!-- menu section -->
   
      <!-- end menu section -->
      <section class="register_type background-page5 min-height-100 position-relative d-flex align-items-center" style="background-image: url('{{ asset('frontEnd/img/Mask Group.png') }}')">
        <div class="container">
           <div class="login text-center">
               <div class="container">
                   <div class="row">
                       <div class="col-md-6 col-12 login2">
                           <div class="left-side">
                               <div class="col-12">
                                   <div class="img_c">
                                    <img src="{{ asset('frontEnd/img/Rectangle_16251-r.png') }}"  alt="">
                                </div>
                               </div>
                               <div class="col-12 mt-3">
                                   <div class="text-left-side">
                                    <h3>{{ $data->title->{app()->getlocale()} }}</h3>
                                    <p>{{ $data->description->{app()->getlocale()} }} </p>
                                   </div>
                                   </div>
                           </div>
                       </div>
                       <img class="arrow-img2" src="{{ asset(app()->getLocale() == 'ar'?'frontEnd/img/Group 50667-ar.png':'frontEnd/img/Group 50667.png') }}" alt="">
                       <div class="col-md-6 col-12 text-center">
                           <div>
                               <div class="title">
                                   <div class="icon">
                                       <img src="{{ asset('frontEnd/img/logo.png') }}" width="150px" height="150px" alt="">
                                   </div>
                                   <h3>{{ trans('messages.frontEnd.choose_membership') }}</h3>
                               </div>
                               <form > 
                                   <div class="d-flex justify-content-sm-between justify-content-center mt-5">
                                       <div class="custom_mrl">
                                           <label class="Advertiser" for="user_type">
                                               <input type="radio" name="user_type" class="d-none" value="{{ route('auth.influencer_register') }}">
                                               <div class="px-3 py-4">
                                                   <img src="{{ asset('frontEnd/img/omnichannel.png') }}" alt=""height="50px">
                                               </div>
                                               <h3>{{ trans('messages.frontEnd.influencer') }}</h3>
                                           </label>
                                       </div>
                                       <div class="">
                                           <label class="Advertiser" for="user_type">
                                               <input type="radio" name="user_type" class="d-none" value="{{ route('auth.customer_register') }}">
                                               <div class="px-3 py-4">
                                                   <img src="{{ asset('frontEnd/img/influencer.png') }}" alt="" height="50px">
                                               </div>
                                               <h3>{{ trans('messages.frontEnd.advertiser') }}</h3>
                                           </label>
                                       </div>
                                   </div>
                                   <div class="mt-5">
                                       <a href="" type="button" class="btn btn-none login-button p-0" id="register">{{ trans('messages.frontEnd.register') }}</a>
                                   </div>
                               </form>
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
     <script type='text/javascript' src='{{ asset('frontEnd/js/jquery-3.6.0.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/bootstrap.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/all.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/main.js') }}'></script>
     <!--End JAVASCRIPT-->
 </body>
</html>
