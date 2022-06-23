@extends('frontEnd.layouts.index')
@section('content')
<section class="section">

    <div class="container">
        <div class="left-bg">
            <img src="{{ asset('frontEnd/img/bg-color.png') }}" width="600px" height="600px" alt="">
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12 pt-5 mt-3 position-relative best-influencer">
                <img class="star" src="{{ asset('frontEnd/img/star.png') }}" width="50px" height="50px" alt="">
                {{-- @php
                dd($data['welcome_message']?->description);
                @endphp --}}
                <h1> {{ $data['welcome_message']?->title }} </h1>
                <p>{{ $data['welcome_message']?->description }}</p>
                <a href="#" class="button-started btn btn-none " type="submit"> Get Started</a>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12 img-influencer">
                <img src="{{ asset('frontEnd/img/inf.png') }}" alt="">
            </div>
        </div>

    </div>
</section>
<!--end text & image section -->
<section class="section">
    <div class="container position-relative ">
        <div class="row">
            <div class="col-lg-6  col-md-12 col-sm-12 position-relative">
                <div class="dotted">
                    <img src="{{ asset('frontEnd/img/Group.png') }}" alt="">
                </div>  
                <img id="img-section2" src="{{ $about_us->image }}" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 text-section2">
                <h1>{{ $about_us->title }} </h1>
                <p>{{ $about_us->description }}</p>
                <a href="#" class="button-more-about btn btn-none " type="submit">More About Us</a>
            </div>
        </div>
    </div>
    <div class="right-dotted">
        <img src="{{ asset('frontEnd/img/Group.png') }}" width="200px" height="200px" alt="">
    </div>
    <div class="left-youtube">
        <img src="{{ asset('frontEnd/img/Icon.png') }}" width="200px" height="200px" alt="">
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center our-working-Process">
                <h1> Our Working Process</h1>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua </p>
            </div>

        </div>
        <div class="row group-images space-row mt-5">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-6 p-1 position-relative">
                        <div id="image1" class="h-100 w-100" alt="">
                            <div class="our-service-image-1">
                                <h4>OUR SERVICE</h4>
                                <p> consectetur adipiscing elit, sed do eiusmod tempor</p>
                                <a href="#" class="read-more-text">READ MORE <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-1">
                        <div class="process_details">
                            <div class="img_shadow"></div>
                            <img src="{{ asset('frontEnd/img/smiley.png') }}" class="h-100 w-100" alt="">
                            <p class="our-service "> Our Service</p>
                        </div>
                    </div>
                    <div class="col-8 p-1">
                        <div class="process_details">
                            <div class="img_shadow4"></div>
                            <img src="{{ asset('frontEnd/img/creative.png') }}" class="h-100 w-100" alt="">
                            <p class="our-service text-start"> Our Service</p>
                        </div>
                    </div>
                    <div class="col-4 p-1">
                        <div class="process_details">
                            <div class="img_shadow3"></div>
                            <img src="{{ asset('frontEnd/img/d1.png') }}" class="h-100 w-100" alt="">
                            <p class="our-service"> Our Service</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 p-1">
                <div class="process_details">
                    <div class="img_shadow2"></div>
                    <img id="image5" src="{{ asset('frontEnd/img/d1.png') }}" class="h-100 w-100" alt="">
                    <div class="our-service-text">
                        <h4>Our service</h4>
                        <p> consectetur adipiscing elit, sed do eiusmod tempor</p>
                        <a href="#" class="read-more-text">READ MORE <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <div class="right-insta">
        <img src="{{ asset('frontEnd/img/Icon2.png') }}" width="200px" height="200px" alt="">
    </div>
    <div class="left-youtube">
        <img src="{{ asset('frontEnd/img/Group2.png') }}" width="300px" height="300px" alt="">
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row">

            <div class="col-12 text-center frequently-asked-questions ">
                <h1> {{ $faq->title }}</h1>
                <p> {{ $faq->description }} </p>
            </div>
        </div>
    </div>
    <div class=" position-relative section-down">
        <div id="color-section">
        </div>
        <div class="container">
            <div class="row">

                <div class="col-6 col-md-6 col-lg-6 full-border faq-col">

                    <div class="accordion" id="accordionExample">
                        @foreach ($faqItems as $key => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Accordion Item #{{ $key+1 }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>{{ $item->question }}</strong>
                                    <p>{{ $item->answer }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    
                        <a href="#" class="read-more mt-3">READ MORE <i class="fa-solid fa-arrow-right"></i></a>

                    </div>

                </div>
                <div class="col-6 col-md-6 col-lg-6">
                    <img id="radius-image" src="{{asset('frontEnd/img/d1.png')}}" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="left-contact">
        <img src="{{ asset('frontEnd/img/contact.png') }}" width="200px" height="200px" alt="">
    </div>
</section>

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
                        <span>Location</span>
                    </div>

                </div>
                <div class="contact-us-text d-flex mt-5">
                    <i class="fa-solid fa-phone fa-3x px-4" style="color:#9686AA ;"></i>
                    <div>
                        <p>{{ $contact_info?->phone }} </p>
                        <span>Phone</span>
                    </div>

                </div>
                <div class="contact-us-text d-flex mt-5">
                    <i class="fa-solid fa-envelope fa-3x px-4" style="color:#9686AA;"></i>
                    <div class="webmail">
                        <a href="{{ $contact_info?->email }}">{{ $contact_info?->email }}</a><br>
                        <span>Mail</span>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <img id="phone" src="{{ asset('frontEnd/img/phone.png') }}" alt="">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 text-center read-more-contact"><a href="#">READ MORE <i
        class="fa-solid fa-arrow-right"></i></a></div>
    </div>
    <div class="right-face">
        <img src="{{ asset('frontEnd/img/Icon3.png') }}" width="200px" height="200px" alt="">
    </div>
</section>
@endsection