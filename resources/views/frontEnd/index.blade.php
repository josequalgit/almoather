@extends('frontEnd.layouts.index')
@section('content')
<section class="section">

    <div class="container">
        <div class="right-star">
            <img src="{{ asset('frontEnd/img/star.svg') }}" alt="">
        </div>
        <div class="left-bg">
            <img src="{{ asset('frontEnd/img/bg-color.png') }}" alt="">
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12 mt-3 best-influencer">
                <div class="text-center">
                    <img class="star" src="{{ asset('frontEnd/img/star.png') }}" width="50" alt="">
                </div>
                <h1> {{ $data['welcome_message']?->title }} </h1>
                <p>{{ $data['welcome_message']?->description }}</p>
                <a href="#" class="button-started btn btn-none " type="submit">{{ trans('messages.frontEnd.start_btn') }}</a>
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
            <div class="col-lg-6 col-md-12 col-sm-12 text-section2 px-md-3 p-2 mt-md-0 mt-4">
                <h1>{{ $about_us->title }} </h1>
                <p>{{ $about_us->description }}</p>
                <a href="{{ route('frontEnd.about') }}" class="button-more-about btn btn-none ">{{ trans('messages.frontEnd.more_about_us') }}</a>
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
                <h1>{{ trans('messages.frontEnd.our_working_process') }}</h1>
            </div>

        </div>
        <div class="row group-images space-row mt-5">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 p-1 position-relative">
                        <div id="image1" class="h-100 w-100" alt="">
                            <div class="our-service-image-1">
                                <h4>{{ trans('messages.frontEnd.our-service') }}</h4>
                                <p> consectetur adipiscing elit, sed do eiusmod tempor</p>
                                <a href="#" class="read-more-text">{{ trans('messages.frontEnd.read_more') }}<i class="fa-solid fa-arrow-{{ app()->getLocale() == 'en'?'right':'left' }}"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6 p-1">
                        <div class="process_details">
                            <div class="img_shadow"></div>
                            <img src="{{ asset('frontEnd/img/smiley.png') }}" class="h-100 w-100" alt="">
                            <p class="our-service "> Our Service</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-8 col-lg-8 p-1">
                        <div class="process_details">
                            <div class="img_shadow4"></div>
                            <img src="{{ asset('frontEnd/img/creative.png') }}" class="h-100 w-100" alt="">
                            <p class="our-service text-start"> Our Service</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 p-1">
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
                        <a href="#" class="read-more-text">{{ trans('messages.frontEnd.read_more') }}<i class="fa-solid fa-arrow-{{ app()->getLocale() == 'en'?'right':'left' }}"></i></a>
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
    <div class="position-relative">
        <div id="color-section"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-lg-6 full-border faq-col">

                    <div class="accordion" id="accordionExample">
                        @foreach ($faqItems as $key => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $item->question }}
                                </button>
                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong></strong>
                                    <p>{{ $item->answer }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    
                        <a href="#" class="read-more mt-3">{{ trans('messages.frontEnd.read_more') }} <i class="fa-solid fa-arrow-{{ app()->getLocale() == 'en'?'right':'left' }}"></i></a>

                    </div>

                </div>
                <div class="col-md-6 col-lg-6">
                    <img id="radius-image" src="{{asset('frontEnd/img/d1.png')}}" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="left-contact">
        <img src="{{ asset('frontEnd/img/contact.png') }}" width="200px" height="200px" alt="">
    </div>
</section>


@endsection