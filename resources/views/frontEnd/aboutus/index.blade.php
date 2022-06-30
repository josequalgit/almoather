@extends('frontEnd.layouts.index')

@section('content')
<section class="banner">
    <div class="banner-wrapper pb-4" style="background-image: url('{{ $data->aboutUsHeader }}');">
    </div>
  </section>

  <section class="map">
    <div class="container position-relative ">
  
      <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 ">
        
            <h1>{{ app()->getLocale() == 'ar'?$data->contentData->section_one->title_ar:$data->contentData->section_one->title_en}}</h1>
            <p>{{ app()->getLocale() == 'ar'?$data->contentData->section_one->description_ar:$data->contentData->section_one->description_en}}</p>
          </div>
        <div class="col-lg-6  col-md-12 col-sm-12 position-relative d-flex">
          
          <div class="mt-5 text-end">
            <img id="business2" src="{{ $data->aboutUsSectionOneImage }}"  alt="">
            <div class="Rectangle-page2">
                <img   src="{{  $data->aboutUsSectionOneImage  }}"   alt="">
              </div>
          </div>
        
        </div>
        
      </div>
    </div>
  </section>


  <section class="background-gray position-relative py-5 my-4">
      <div class="container py-5">
            <div class="row how-it-work pt-5 pb-3">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="img-on-gray">
                      <img   src="{{  $data->aboutUsSectionTwoImage  }}"   alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                    <div class="img-on-gray2">
                      <h1>{{ app()->getLocale() == 'ar'?$data->contentData->section_two->title_ar:$data->contentData->section_two->title_en}}</h1>
                      <p>{{ app()->getLocale() == 'ar'?$data->contentData->section_two->description_ar:$data->contentData->section_two->description_en}}</p>
                    </div>
                </div>
           
            </div>
      </div>
  </section>

  <section class="section pb-5">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 save-your-time text-center">
            <h1> Save your time and money by choosing our professional team.</h1>
          </div>
        </div>
        <div class="row  d-flex mt-5 position-relative text-center">
          <div class="test row-eq-height" data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'>
          
           @foreach ($team as $item)
           <div>
            <div class="col p-2" >
              <div class="card card-slider-att p-3">
                  <div class="img-center text-center mt-2">
                      <img  src="{{ $item->image['url'] }}" alt="">
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title mt-4">{{ $item->name }}</h5>
                    <p class="card-text mt-4">{{ $item->description }}</p>
                    <div class="social d-flex justify-content-center">
                      <a href="asdasd" class="me-2"><i class="fa-brands fa-facebook-f color"></i></a>
                      <a href="asdasd" class="me-2"><i class="fa-brands fa-twitter color"></i></a>
                    </div>
                  </div>
                </div>
            </div>
         </div>
           @endforeach
          </div>
          
          
          
        </div>
    </div>
  </section>
 
  <section class="section-top my-5 py-5">
    <div class="background-gray2">
      <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-3 col-sm-3 d-flex p-5">
                <div class="col-3 text-center ">
                    <img src="{{ asset('frontEnd/img/Menu.png') }}" alt="" width="100px" height="100px">
                    <div class="icon-last-section">
                        <h5>7581</h5>
                        <p>Completed Projects</p>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <img src="{{ asset('frontEnd/img/step-1.png') }}" alt="" width="100px" height="100px">
                    <div class="icon-last-section">
                        <h5>7581</h5>
                        <p>Completed Projects</p>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <img src="{{ asset('frontEnd/img/Join-us.png') }}" alt="" width="100px" height="100px">
                    <div class="icon-last-section">
                        <h5>7581</h5>
                        <p>Completed Projects</p>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <img src="{{ asset('frontEnd/img/gift-card-applied.png') }}" alt="" width="100px" height="100px">
                    <div class="icon-last-section">
                        <h5>7581</h5>
                        <p>Completed Projects</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  </section>
  
@endsection

@section('scripts')
<script>
  $('.test').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 3
});

</script>
@endsection