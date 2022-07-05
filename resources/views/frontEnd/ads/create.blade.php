@extends('frontEnd.layouts.index')

@section('content')
<section class="background-page14 position-relative py5">
    <div class="py-5">
        <div class="contract text-center position-relative">
            <h1>{{ trans('messages.frontEnd.my_ads') }}</h1>
            <p>{{ trans('messages.frontEnd.please_add_the_ad_information_in_the_form_below') }}</p>
        </div>
        <div class="img-first-page2 position-absolute text-center">
            
        </div>
    </div>
 </section>

 <form action="{{ route('storeAdApi') }}" method="POST">
    <section  class="section-contract">
    <div class="">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center full-border-my-ads p-md-5">
                <div class="row">
                    <div class="col-lg-12  your-scenario">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.logo') }}</h3>
                        <input name="logo" id="store" type="file" class="form-control mt-3">
                    </div>  
                    <div class="col-lg-12  your-scenario">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.store_name') }}</h3>
                        <input name="store" id="store" type="text" class="form-control mt-3">
                    </div>  
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.cr_number') }}</h3>
                        <input name="cr_number" id="cr_number" type="number" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.add_cr_file') }}</h3>
                        <input name="cr_file" id="cr_number" type="file" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.dose_your_store_on_marof') }}</h3>
                        <div class="row">
                            <div class="form-check">
                                <input id="show_marou_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Yes
                                </label>
                              </div>
                              <div class="form-check">
                                <input id="hide_marou_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                  No
                                </label>
                              </div>
                        </div>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.marof_number') }}</h3>
                        <input name="marouf_num" id="marouf_num" type="number" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.ad_type') }}</h3>
                        <select class="form-control" name="ad_type" id="ad_type">
                            <option value="onsite">{{ trans('messages.frontEnd.onsite') }}</option>
                            <option value="online">{{ trans('messages.frontEnd.online') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-12  your-scenario">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.add_cr_file') }}</h3>
                        <input name="logo" id="store" type="file" class="form-control mt-3">
                    </div>  
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > {{ trans('messages.frontEnd.enter_budget') }} </h3>
                        <input name="budget" id="budget" type="number" class="form-control mt-3">

                    </div>
                    <div class="col-lg-12  text-center your-scenario mt-4">
                       <div class="row justify-content-between">
                        <div class="col-md-5 col-12 store-input">
                          <h3  class="float-start"> {{ trans('messages.frontEnd.store_logo') }} </h3>
                          <input type="text" class="form-control mt-3">
                        </div>
                        <div class="col-md-5 col-12 store-input">
                              <h3 class="float-start"> {{ trans('messages.frontEnd.influencer_social_media') }} </h3>
                              <input type="text" class="form-control mt-3">
                        </div>
                       </div>
                    </div>
                    
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.your_scenario') }}</h3>
                        <textarea type="text" class="form-control mt-3"></textarea>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > Store Location </h3>
                        <input type="text" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > Product Information </h3>
                        <textarea type="text" class="form-control mt-3"></textarea>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > My Offer </h3>
                        <input type="text" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > Commercial Documents </h3>
                        <input type="text" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > My Product </h3>
                    </div>
                    <div class="col-lg-12  your-scenario d-flex">
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <img src="{{ asset('frontEnd/img/shop-clothing-clothes-shop-hanger-modern-shop-boutique.png') }}" alt="" >
                          </div>
                          <div class="col-md-4 col-12">
                              <img src="{{ asset('frontEnd/img/shop-clothing-clothes-shop-hanger-modern-shop-boutique.png') }}" alt="">
                          </div>
                          <div class="col-md-4 col-12">
                              <img src="{{ asset('frontEnd/img/shop-clothing-clothes-shop-hanger-modern-shop-boutique.png') }}" alt="">
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-12  text-center your-scenario mt-4">
                        <div class="row justify-content-between">
                            <div class="col-md-5 col-12">
                              <h3  class="float-start"> Price Before </h3>
                              <input type="text" class="form-control mt-3">
                            </div>
                          <div class="col-md-5 col-12">
                                <h3 class="float-start"> Price Now </h3>
                                <input type="text" class="form-control mt-3">
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-12  text-center your-scenario mt-4">
                      <div class="row justify-content-between">
                        <div class="col-md-5 col-12">
                          <h3  class="float-start"> Date </h3>
                          <input type="text" class="form-control mt-3">
                        </div>
                        <div class="col-md-5 col-12">
                              <h3 class="float-start"> Discount Code </h3>
                              <input type="text" class="form-control mt-3">
                        </div>
                      </div>
                     </div>
                     <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > Video about my product </h3>
                        <img src="{{ asset('frontEnd/img/Video.png') }}" alt="">
                    </div>
                </div>
             </div>
          </div>
        </div>
    </div>
  </section>
 </form>

<script>
    function toggle(status)
    {
        if(status == 'no')
        {
            $('')
        }
    }
</script>


@endsection