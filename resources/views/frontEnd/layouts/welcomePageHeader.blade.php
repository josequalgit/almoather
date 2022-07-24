<section class="section-menu py-3">
    <div class="container">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-faded">
            <div>
                <a href="{{ URL::to('/') }}">
                    <img class="img" src="{{ asset('frontEnd/img/logo.png') }}" width="90px" alt="Almuuathir">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @php
       $prefix = Request::route()->getPrefix();
       $name = Request::route()->getName();
    @endphp
            <div class="collapse navbar-collapse" style="justify-content:space-evenly ;" id="navbarSupportedContent">
                @if($prefix == 'customers'||$prefix == "customers/ad"||$prefix == '/customers')
                <ul class="navbar-nav nav-bar-menu">
                    <li> <a  id="home" class="nav-item nav-link {{ $name == 'customers.index'?'active':'' }}" href="{{ route('customers.index') }}">{{ trans('messages.frontEnd.profile') }}</a></li> 
                    <li> <a class="nav-item nav-link" href="#">{{ trans('messages.frontEnd.my_ads') }}</a></li> 
                    <li> <a class="nav-item nav-link {{ $name == 'customers.ads.index'|| $name == 'customers.ads.create'?'active':'' }}" href="{{ route('customers.ads.create') }}">{{ trans('messages.frontEnd.create') }}</a></li> 
                    <li> <a class="nav-item nav-link" href="{{ route('changeLanguage') }}">{{ app()->getLocale() == 'ar'?'English':'العربي' }}</a></li>
                    <li> <a class="nav-item nav-link" href="{{ route('auth.frontEnd.logout') }}">{{ trans('messages.frontEnd.logout') }}</a></li>
                </ul>
                @else
                <ul class="navbar-nav nav-bar-menu">
                    <li> <a id="home" class="nav-item nav-link {{ $name == 'frontEnd.index'?'active':'' }}" href="{{ route('frontEnd.index') }}">{{ trans('messages.frontEnd.home') }}</a></li>
                    <li> <a class="nav-item nav-link {{ $name == 'frontEnd.about'?'active':'' }}" href="{{ route('frontEnd.about') }}">{{ trans('messages.frontEnd.about') }}</a></li>
                    <li> <a class="nav-item nav-link {{ $name == 'frontEnd.ourservice'?'active':'' }}" href="{{ route('frontEnd.ourservice') }}">{{ trans('messages.frontEnd.our-service') }}</a></li>
                    <li> <a class="nav-item nav-link {{ $name == 'contact.index'?'active':'' }}" href="{{ route('contact.index') }}">{{ trans('messages.frontEnd.contact') }}</a></li>
                    <li> <a class="nav-item nav-link" href="{{ route('changeLanguage') }}">{{ app()->getLocale() == 'ar'?'English':'العربي' }}</a></li>

                </ul>
                @endif
              
              
                <div class="social d-flex">
                    @if(Auth::check())
                    <a href="#" class="me-2">
                        <div class="icon-box d-flex justify-content-center align-items-center"><img src="{{ asset('frontEnd/img/Search.svg') }}" alt=""></div>
                    </a>
                    <a href="{{ route('customers.index') }}" class="me-2">
                        <div class="icon-box d-flex justify-content-center align-items-center"><img src="{{ asset('frontEnd/img/user.svg') }}" alt=""></div>
                    </a>
                    @else
                    <a class="button-a btn btn-none me-2" href="{{ route('auth.login') }}">{{ trans('messages.frontEnd.login') }}</a>
                    <a class="button-a btn btn-none me-2" href="{{ route('auth.register_type') }}" id="signup">{{ trans('messages.frontEnd.register') }}</a>

                    @endif
                </div>

            </div>

        </nav>
    </div>
</section>