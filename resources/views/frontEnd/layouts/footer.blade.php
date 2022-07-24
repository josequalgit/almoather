<div class="footer-bg">
    @if($name == 'frontEnd.index')
    <!-- Contact us -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 contact-us text-center">
                    <h1> {{ $contact_us->title }}</h1>
                    <p> {{ $contact_us->description }} </p>
                </div>
            </div>
            <div class="row space-row mt-4">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="contact-us-text d-flex mt-5">
                        <i class="fa-solid fa-location-dot fa-3x px-4" style="color:#9686AA ;"></i>
                        <div>
                            
                            <p>{{ $contact_info?->location }} </p>
                            <span>{{ trans('messages.frontEnd.location') }}</span>
                        </div>
    
                    </div>
                    <div class="contact-us-text d-flex mt-5">
                        <i class="fa-solid fa-phone fa-3x px-4" style="color:#9686AA ;"></i>
                        <div>
                            <p>{{ $contact_info?->phone }} </p>
                            <span>{{ trans('messages.frontEnd.phone') }}</span>
                        </div>
    
                    </div>
                    <div class="contact-us-text d-flex mt-5">
                        <i class="fa-solid fa-envelope fa-3x px-4" style="color:#9686AA;"></i>
                        <div class="webmail">
                            <a href="{{ $contact_info?->email }}">{{ $contact_info?->email }}</a><br>
                            <span>{{ trans('messages.frontEnd.mail') }}</span>
                        </div>
    
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <img id="phone" src="{{ asset('frontEnd/img/phone.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 text-center read-more-contact"><a href="#">{{ trans('messages.frontEnd.read_more') }} <i
            class="fa-solid fa-arrow-{{ app()->getLocale() == 'en'?'right':'left' }}"></i></a></div>
        </div>
        
    </section>
    <!-- End Contact us -->
    @endif

    <!-- Footer -->
    <section class="footer-section">
        <div class="right-face">
            <img src="{{ asset('frontEnd/img/Icon3.png') }}" width="200px" height="200px" alt="">
        </div>
        <div class="right-flowo">
            <img src="{{ asset('frontEnd/img/group_footer.png') }}" width="200px" height="200px" alt="">
        </div>

        <footer class="footer pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_logo">
                            <img src="{{ asset('frontEnd/img/logo.png') }}" alt="footer_logo">
                        </div>
                        <div class="footer-details">
                            <h4>AL Muaathir</h5>
                                <p>{{ $website_des->{app()->getLocale()} }}</p>
                        </div>
                        <div class="Social Media">
                            <h4>{{ trans('messages.frontEnd.social_media') }}</h6>
                                <div class="social d-flex">
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-facebook-f"></i></div>
                                    </a>
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-youtube"></i></div>
                                    </a>
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-twitter"></i></div>
                                    </a>
                                </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_links">
                            <h4>{{ trans('messages.frontEnd.quick_links') }}</h4>
                            <ul class="quick_links">
                                <li><a href="{{ route('frontEnd.about') }}">{{ trans('messages.frontEnd.about') }}</a></li>
                                <li><a href="{{ route('frontEnd.ourservice') }}">{{ trans('messages.frontEnd.our-service') }}</a></li>
                                <li><a href="{{ route('contact.index') }}">{{ trans('messages.frontEnd.contact') }}</a></li>
                                {{-- <li><a href="#">Faq</a></li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_contact">
                            <h4>{{ trans('messages.frontEnd.contact_info') }}</h4>
                            <ul class="contact_links">
                                <li><i class="fa-solid fa-location-dot fa-xl"></i><a>{{ $contact_info?->location }}</a></li>
                                <li><i class="fa-solid fa-phone fa-xl"></i><a href="tel:{{ $contact_info?->phone }}">{{ $contact_info?->phone }}</a></li>
                                <li><i class="fa-solid fa-envelope fa-xl"></i><a href="{{ $contact_info?->email }}">{{ $contact_info?->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </footer>
    </section>
    <!-- End Footer -->
</div>