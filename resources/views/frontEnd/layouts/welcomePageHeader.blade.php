<section class="section-menu py-3">
    <div class="container">
        <div class="right-star">
            <img src="{{ asset('frontEnd/img/star.svg') }}" width="200px" height="200px" alt="">
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-faded">
            <div>
                <img class="img" src="{{ asset('frontEnd/img/logo.png') }}" width="70px" height="70px" alt="">

            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
            <div class="collapse navbar-collapse mx-auto w-auto " style="justify-content:space-evenly ;" id="navbarSupportedContent">
                <ul class="navbar-nav nav-bar-menu">
                    <li> <a id="home" class="nav-item nav-link {{ $name == 'frontEnd.index'?'active':'' }}" href="{{ route('frontEnd.index') }}">Home </a></li>
                    <li> <a class="nav-item nav-link" href="about.html">About</a></li>
                    <li> <a class="nav-item nav-link" href="our-services.html">Our Service</a></li>
                    <li> <a class="nav-item nav-link {{ $name == 'contact.index'?'active':'' }}" href="{{ route('contact.index') }}">Contact Us</a></li>

                </ul>
                <div class="social d-flex">
                    <a class="button-a btn btn-none me-2" href="{{ route('auth.login') }}">Login</a>
                    <a class="button-a btn btn-none me-2" href="{{ route('auth.register_type') }}" id="signup">Sign Up</a>
                    <a href="#" class="me-2">
                        <div class="icon-box d-flex justify-content-center align-items-center"><img src="{{ asset('frontEnd/img/Search.svg') }}" alt=""></div>
                    </a>
                    <a href="#" class="me-2">
                        <div class="icon-box d-flex justify-content-center align-items-center"><img src="{{ asset('frontEnd/img/user.svg') }}" alt=""></div>
                    </a>
                </div>

            </div>

        </nav>
    </div>
</section>