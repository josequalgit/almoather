@extends('frontEnd.layouts.index')
@section('content')
<section class="background-page10 position-relative py-5">
         @php
            App::setLocale('en');    
         @endphp
    <div class="py-5">
        <div class="contract text-center">
            <h1>Welcome Back</h1>
            <p>{{ auth()->user()->customers->full_name }}</p>
        </div>
    </div>
    <div class="position-absolute flower">
        <img src="assets/img/Group 55162.png" alt="" width="260px">
    </div>
 </section>

 <section  class="section-contract">
    <div class="min-height-100">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-lg-12 col-md-12 col-sm-12   mt-5 ">
                <ul class="nav nav-pills  justify-content-between text-center" id="pills-tab" role="tablist" >
                    <li class="nav-item content-button col-md-3 col-6 " role="presentation ">
                        <button class="nav-link btn btn-none active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ trans('messages.frontEnd.active') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button class="nav-link btn btn-none" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ trans('messages.frontEnd.pending') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation ">
                        <button class="nav-link btn btn-none" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.rejected') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button class="nav-link btn btn-none" id="pills-Canceled-tab" data-bs-toggle="pill" data-bs-target="#pills-Canceled" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.finished') }}</button>
                    </li>
                  </ul>
                  <div class="container">
                    <div class="tab-content " id="pills-tabContent">
                        <div class="tab-pane ul-content fade show active w-40" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row text-center mt-3">
                                <div class="col-sm-4">
                                  <div class="card background-box-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-end">
                                                <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                            </div>
                                            <div class="col text-start above-text">
                                                <p >Store name</p>  
                                                <span>Product</span>  
                                            </div>
                                            <hr class="mt-2 hr-content" width="80px">
                                            <div class="col text-start left-text">
                                                <p>Site Advertiser</p>  
                                                <span>Jordan</span>   
                                            </div>
                                            <div class="col text-end right-text">
                                                <p>22698</p>  
                                                <span>(1-9-2022)</span>  
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card background-box-content">
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col text-end">
                                                  <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                              </div>
                                              <div class="col text-start above-text">
                                                  <p >Store name</p>  
                                                  <span>Product</span>  
                                              </div>
                                              <hr class="mt-2 hr-content" width="80px">
                                              <div class="col text-start left-text">
                                                  <p>Site Advertiser</p>  
                                                  <span>Jordan</span>   
                                              </div>
                                              <div class="col text-end right-text">
                                                  <p>22698</p>  
                                                  <span>(1-9-2022)</span>  
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card background-box-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-end">
                                                <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                            </div>
                                            <div class="col text-start above-text">
                                                <p >Store name</p>  
                                                <span>Product</span>  
                                            </div>
                                            <hr class="mt-2 hr-content" width="80px">
                                            <div class="col text-start left-text">
                                                <p>Site Advertiser</p>  
                                                <span>Jordan</span>   
                                            </div>
                                            <div class="col text-end right-text">
                                                <p>22698</p>  
                                                <span>(1-9-2022)</span>  
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                              </div>
                              <div class="row text-center mt-3">
                                <div class="col-sm-4">
                                    <div class="card background-box-content">
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col text-end">
                                                  <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                              </div>
                                              <div class="col text-start above-text">
                                                  <p >Store name</p>  
                                                  <span>Product</span>  
                                              </div>
                                              <hr class="mt-2 hr-content" width="80px">
                                              <div class="col text-start left-text">
                                                  <p>Site Advertiser</p>  
                                                  <span>Jordan</span>   
                                              </div>
                                              <div class="col text-end right-text">
                                                  <p>22698</p>  
                                                  <span>(1-9-2022)</span>  
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card background-box-content">
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col text-end">
                                                  <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                              </div>
                                              <div class="col text-start above-text">
                                                  <p >Store name</p>  
                                                  <span>Product</span>  
                                              </div>
                                              <hr class="mt-2 hr-content" width="80px">
                                              <div class="col text-start left-text">
                                                  <p>Site Advertiser</p>  
                                                  <span>Jordan</span>   
                                              </div>
                                              <div class="col text-end right-text">
                                                  <p>22698</p>  
                                                  <span>(1-9-2022)</span>  
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card background-box-content">
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col text-end">
                                                  <img src="assets/img/Path 142733.png" alt="" width="60px" height="60px">
                                              </div>
                                              <div class="col text-start above-text">
                                                  <p >Store name</p>  
                                                  <span>Product</span>  
                                              </div>
                                              <hr class="mt-2 hr-content" width="80px">
                                              <div class="col text-start left-text">
                                                  <p>Site Advertiser</p>  
                                                  <span>Jordan</span>   
                                              </div>
                                              <div class="col text-end right-text">
                                                  <p>22698</p>  
                                                  <span>(1-9-2022)</span>  
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                        <div class="tab-pane fade" id="pills-Canceled" role="tabpanel" aria-labelledby="pills-Canceled-tab">...</div>
                      </div>
                  </div>
                  
             </div>
          </div>
       
        </div>
      </div>
  
  </section>
@endsection