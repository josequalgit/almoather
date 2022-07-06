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
                        <h3 class="float-start" >{{ trans('messages.frontEnd.cr_number') }}</p></h3>
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
                                <input   id="show_marou_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    {{ trans('messages.frontEnd.yes') }}
                                </label>
                              </div>
                              <div class="form-check">
                                <input id="hide_marou_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                    {{ trans('messages.frontEnd.no') }}
                                </label>
                              </div>
                        </div>
                    </div>
                    <div class="col-lg-12  your-scenario" id="add_cr_document_label">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.add_cr_document') }}</h3>
                        <input name="add_cr_document" id="add_cr_document" type="file" class="form-control mt-3">
                    </div>  
                    <div id="add_marof_numbe" class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.marof_number') }}</h3>
                        <input name="marouf_num" id="marouf_num" type="number" class="form-control mt-3">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" >{{ trans('messages.frontEnd.are_you_under_added_value') }}  <p id="cr_no_note">({{ trans('messages.frontEnd.cr_no_note') }})</h3>
                        <div class="row">
                            <div class="form-check">
                                <input   id="show_cr_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    {{ trans('messages.frontEnd.yes') }}
                                </label>
                              </div>
                              <div class="form-check">
                                <input id="hide_cr_num" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                    {{ trans('messages.frontEnd.no') }}
                                </label>
                              </div>
                        </div>
                    </div>


                    <div id="cr_num" class="col-lg-12  your-scenario mt-4">
                        <h3 class="float-start" > {{ trans('messages.frontEnd.cr_num') }}</h3>
                        <input name="cr_num"  type="number" class="form-control mt-3">
                    </div>

                    <div id="cr_num" class="col-lg-12  your-scenario mt-4 input-adv">
                        <h3 class="float-start" > {{ trans('messages.frontEnd.ad_relation') }}</h3>
                        <select name="gender" class="form-control" id="gender" >
                            @foreach ($relations as $item)
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>                                
                            @endforeach
                        </select>
                       
                    </div>
                   

                </div>
             </div>
          </div>
        </div>
    </div>
  </section>
 </form>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
    $('#cr_num').hide();
    $('#cr_no_note').hide();
  $('#show_marou_num').click(function(){
    $('#add_marof_numbe').show();
    $('#add_cr_document_label').hide();
  });
  $('#hide_marou_num').click(function(){
    $('#add_marof_numbe').hide();
    $('#add_cr_document_label').show();
  });

  $('#show_cr_num').click(function(){
    $('#cr_num').show();
    $('#cr_no_note').hide();
  });
  $('#hide_cr_num').click(function(){
    $('#cr_num').hide();
    $('#cr_no_note').show();
  });

</script>


@endsection