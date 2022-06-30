@extends('frontEnd.layouts.index')

@section('content')
<style>
.modal-dialog {
    max-width: 78% !important;
    margin: 1.75rem auto;
    height: 600px !important;
}
.modal-content {
 
 /* 80% of window height */

 height: 60%;


}       


</style>
       <!-- first 1 -->
       <section class="section ">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <h1>{{ $data->title }}</h1>
              <p> {{ $data->description }} </p>
            </div>
          </div>
        </div>
          <div class="container">
            <div class="row position-relative" >
              <div>
                <img class="radius-20" src="{{ $data->servicePageFiles->header }}" width="100%" alt="">
              </div>
              <div class="row mt-5">
                <div class="col-lg-6 col-md-12 col-sm-12 text-right service-we-offer mt-5">
                    <h3 > {{ app()->getLocale() == 'ar'?$data->contentData->title_ar_section_one:$data->contentData->title_en_section_one }} </h3>
                    <p class="pt-4" >{{ app()->getLocale() == 'ar'?$data->contentData->description_ar_section_one:$data->contentData->description_en_section_one }}</p>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 text-right d-flex w-45" >
                  <div class="col-6" style="display:grid ;">
                    <div id="support1" class="support">
                      <img  src="{{ asset('frontEnd/img/gift.png') }}" width="40px" height="40px" alt="">
                      <h6 class="mt-3">{{ app()->getLocale() == 'ar'?$data->contentData->card_one_title_ar:$data->contentData->card_one_title_en }}</h6>
                      <p>{{ app()->getLocale() == 'ar'?$data->contentData->card_one_description_ar:$data->contentData->card_one_description_en }}</p>
                    </div>
                    <div id="support2" class="support">
                      <img  src="{{ asset('frontEnd/img/gift2.png') }}" width="40px" height="40px" alt="">
                      <h6 class="mt-3">{{ app()->getLocale() == 'ar'?$data->contentData->card_two_title_en:$data->contentData->card_two_title_en }}</h6>
                     <p>{{ app()->getLocale() == 'ar'?$data->contentData->card_two_description_ar:$data->contentData->card_two_description_ar }}</p>
                   </div>
                  </div>
                  <div class="col-6 pt-4"  style="display:grid ;">
                    <div id="support3"class="support">
                      <img  src="{{ asset('frontEnd/img/gift.png') }}" width="40px" height="40px" alt="">
                      <h6 class="mt-3">{{ app()->getLocale() == 'ar'?$data->contentData->card_three_title_en:$data->contentData->card_three_title_en }}</h6>
                      <p>{{ app()->getLocale() == 'ar'?$data->contentData->card_three_description_ar:$data->contentData->card_three_description_ar }}</p>
                    </div>
                    <div id="support4" class="support pb-2">
                      <img  src="{{ asset('frontEnd/img/gift3.png') }}" width="40px" height="40px" alt="">
                      <h6 class="mt-3">{{ app()->getLocale() == 'ar'?$data->contentData->card_four_title_en:$data->contentData->card_four_title_en }}</h6>
                      <p>{{ app()->getLocale() == 'ar'?$data->contentData->card_four_description_ar:$data->contentData->card_four_description_ar }}</p>                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
      <!-- End  -->
      
      <section class="map position-relative">
        <div class="video-section py-5" style="background-image: url('{{ $data->servicePageFiles->video_backgroundImage }}');">
            <div class="opacity-bg"></div>
            <div class=" d-flex flex-column align-items-center justify-content-center position-relative py-5" style="z-index: 1;">
                <button onclick="openVideoModel()" href="#" style="background: none;
                color: inherit;
                border: none;
                padding: 0;
                font: inherit;
                cursor: pointer;
                outline: inherit;" class="mb-5">
                    <div class="play-button d-flex align-items-center justify-content-center"><i class="fa-solid fa-play"></i></div>
                </button>
                <p>{{ app()->getLocale() == 'ar'?$data->contentData->video_section_title_ar:$data->contentData->video_section_title_en }}</p>
            </div>
        </div>
      </section>

      <section class="map position-relative">
        <div class="container">
          <div class="left-dotted-page3">
            <img  src="{{ asset('frontEnd/img/Group2.png') }}" width="300px" height="300px" alt="">
          </div>
          <div class="row">
            <div class="col-lg-6  col-md-12 col-sm-12 d-flex">
  
              <div class="col-6 mt-5">
                <img class="radius-20" id="business" src="{{ asset('frontEnd/img/business-team-manager-meeting.png') }}"  alt="">
                
              </div>
              <div class="col-6 px-4" style="display:grid ;">
                <div class="Rectangle position-relative me-5 mb-4">
                  <img  src="{{ asset('frontEnd/img/Rectangle 16354.png') }}" alt="">
                  <div class="text-rec text-center" >
                    <h5>6000 +</h5>
                    <h5>saties fide</h5>
                  </div>
                </div>
                <div class="Rectangle">
                  <img class="radius-20" src="{{ asset('frontEnd/img/group-people-working-out-business-plan-office.png') }}"   alt="">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 text-section-bus">
              <h1>{{ app()->getLocale() == 'ar'?$data->contentData->title_ar_section_two:$data->contentData->title_en_section_two }}</h1>
              <p>{{ app()->getLocale() == 'ar'?$data->contentData->description_ar_section_two:$data->contentData->description_en_section_two }}</p>
            </div>
          </div>
        </div>
      </section>

      <div id="video-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <video width="100%" controls>
                <source src="{{ $data->servicePageFiles->video }}" type="video/mp4">
                <source src="movie.ogg" type="video/ogg">
                Your browser does not support the video tag.
              </video>
              
            <div class="modal-footer">
              {{-- <button onclick="openVideoModel()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            </div>
          </div>
        </div>
      </div>
      

      <script>
        function openVideoModel()
        {
          $('#video-modal').modal('toggle');
        }
      </script>
      <!-- Footer -->
@endsection