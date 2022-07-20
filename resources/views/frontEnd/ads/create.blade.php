@extends('frontEnd.layouts.index')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo&family=El+Messiri:wght@500&display=swap" rel="stylesheet">
<style>
    .danger-border{
    border-color: red;
    }
    .your-scenario h3 {
    color: #000000;
    font-size: 22px;
    font-weight: 500;
    font-family: 'El Messiri', sans-serif;
}
.contract h1 {
    font-size: 26px;
    font-weight: bold;
    color: #ffffff;
    font-weight: 500;
    font-family: 'El Messiri', sans-serif;
}

.contract p {
    font-size: 26px;
    font-weight: bold;
    color: #ffffff;
    font-weight: 500;
    font-family: 'El Messiri', sans-serif;
}
#account_media_title{
    color: #000000;
    font-size: 22px;
    font-weight: 500;
    font-family: 'El Messiri', sans-serif;
}
.fab {
    font-size: 2rem;
}


</style>
<section class="background-page14 position-relative py5" style="background-image: url({{ asset('frontEnd/img/handsome-2.png')}})">
    <div class="py-5">
        <div class="contract text-center position-relative">
            <h1>{{ trans('messages.frontEnd.create_ads') }}</h1>
            <p>{{ trans('messages.frontEnd.please_add_the_ad_information_in_the_form_below') }}</p>
        </div>
        <div class="img-first-page2 position-absolute text-center">
            
        </div>
    </div>
 </section>

 <form id="storeForm" action="{{ route('storeAdApi') }}" method="POST">
    <section  class="section-contract">
    <div class="">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center full-border-my-ads p-md-5">
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <img id="user-image" height="160px" width="155px" class="back-ground-advertiser rounded-circle" src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-12  your-scenario">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.logo') }}</h3>
                        <input onchange="loadFile(event)" name="logo" id="store" type="file" class="form-control mt-3 required">
                    </div>  
                    <div class="col-lg-12  your-scenario  mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.store_name') }}</h3>
                        <input name="store" id="store" type="text" class="form-control mt-3 required">
                    </div>  
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.cr_number') }}</p></h3>
                        <input name="cr_num" id="cr_num" type="number" class="form-control mt-3 required">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.add_cr_file') }}</h3>
                        <input name="cr_image" id="cr_image" type="file" class="form-control mt-3 required">
                    </div>

                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.commercial_doc') }}</h3>
                        <input name="commercial_doc[]" id="commercial_doc" type="file" class="form-control mt-3 required">
                    </div>
                    
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.dose_your_store_on_marof') }}</h3>
                        <div class="row">
                            <fieldset id="group1">
                            <div class="form-check d-flex align-items-center">
                                <input   id="show_marou_num" class="required me-2 ms-0" type="radio" name="group1">
                                <label class="form-check-label" for="show_marou_num">
                                    {{ trans('messages.frontEnd.yes') }}
                                </label>
                              </div>
                              <div class="form-check d-flex align-items-center">
                                <input id="hide_marou_num" class="required me-2 ms-0 " type="radio" name="group1" >
                                <label class="form-check-label" for="hide_marou_num">
                                    {{ trans('messages.frontEnd.no') }}
                                </label>
                              </div>
                            </fieldset>

                        </div>
                    </div>

                    <div class="col-lg-12  your-scenario  mt-4" id="add_cr_document_label">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.add_cr_document') }}</h3>
                        <input name="add_cr_document" id="add_cr_document" type="file" class="form-control mt-3 required">
                    </div>  

                    <div id="add_marof_numbe" class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.marof_number') }}</h3>
                        <input name="marouf_num" id="marouf_num" type="number" class="form-control required mt-3">
                    </div>

                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.are_you_under_added_value') }}  <p id="cr_no_note">({{ trans('messages.frontEnd.cr_no_note') }})</h3>
                        <div class="row">
                            <fieldset id="group2">
                            <div class="form-check d-flex align-items-center">
                                <input id="show_tax_value" class="me-2 ms-0" type="radio" name="group2">
                                <label class="form-check-label" for="show_tax_value">
                                    {{ trans('messages.frontEnd.yes') }}
                                </label>
                              </div>
                              <div class="form-check d-flex align-items-center">
                                <input id="hide_tax_value" class="me-2 ms-0" type="radio" name="group2">
                                <label class="form-check-label" for="hide_tax_value">
                                    {{ trans('messages.frontEnd.no') }}
                                </label>
                              </div>
                            </fieldset>

                        </div>
                    </div>

                    <div id="tax_value" class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.tax_value') }}</h3>
                        <input name="tax_value"  type="number" class="form-control mt-3 required">
                    </div>

                  

                   

                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.ad_relation') }}</h3>
                        <select name="relation_id" class="form-control required" id="relation_id" >
                            @foreach ($relations as $item)
                                <option value="{{ $item->id }}" >{{ $item->title }}</option>                                
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.about_company') }}</h3>
                       <textarea maxlength="500" id="about" name="about" class="form-control required" ></textarea>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.about_product') }}</h3>
                       <textarea maxlength="500" id="about_product" name="about_product" class="form-control required" ></textarea>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.campaign_goals') }}</h3>
                        <select name="campaign_goals_id" class="form-control required" id="campaign_goals_id" >
                            @foreach ($goals as $item)
                                <option value="{{ $item->id }}" >{{ $item->title }}</option>                                
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.ad_location') }}</h3>
                    </div>

                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <select name="country_id" class="form-control required" id="country_id" >
                            @foreach ($countries as $item)
                                <option value="{{ $item->id }}" >{{ $item->name }}</option>                                
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <select disabled name="area_id" class="form-control required" id="area_id" >
                                <option value="" >{{ trans('messages.frontEnd.area') }}</option>                                
                        </select>
                    </div>

                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <select disabled name="city_id" class="form-control required" id="city_id" >
                                <option value="" >{{ trans('messages.frontEnd.city') }}</option>                                
                        </select>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <div class="col-lg-12  your-scenario mt-4">
                            <h3 class="text-start" > {{ trans('messages.frontEnd.ad_type') }}</h3>
                        </div>
                        <select name="ad_type" class="form-control required" id="ad_type" >
                                <option value="onsite" >{{ trans('messages.frontEnd.onsite') }}</option>                                
                                <option value="online" >{{ trans('messages.frontEnd.online') }}</option>                                
                        </select>
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" > {{ trans('messages.frontEnd.enter_budget') }}</h3>
                       <input id="budget" name="budget"  type="number" class="form-control mt-3 required">
                    </div>
                    <div class="col-lg-12  your-scenario mt-4">
                        <h3 class="text-start" >{{ trans('messages.frontEnd.store_link') }}</h3>
                       <input id="store_link" name="store_link"  type="text" class="form-control mt-3 required">
                    </div>
                  
                    <div class="col-lg-12  your-scenario mt-4 input-adv">
                        <div class="col-lg-12  your-scenario mt-4">
                            <h3 class="text-start" > {{ trans('messages.frontEnd.choose_influncer_platform') }}</h3>
                        </div>
                        <select name="prefered_media_id" class="form-control required" id="prefered_media_id" >
                                <option value="4" >Snapchat</option>                                
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <label class="mb-2" for="inputAddress2"><h1 id="account_media_title">{{ trans('messages.frontEnd.your_account_media') }}</h1></label>
                        <div class="row">
                            @foreach ($socialMedia as $item)
                                <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="mr-2 text-center">
                                                @switch($item->name)
                                                @case('Facebook')
                                                    <i class="s-icon fab fa-facebook-square"></i>
                                                    @break
                                                @case('Snapchat')
                                                    <i class="s-icon fab fa-snapchat-square"></i>
                                                    @break
                                                @case('Twitter')
                                                    <i class="s-icon fab fa-twitter-square"></i>
                                                    @break
                                                @case('Instagram')
                                                    <i class="s-icon fab fa-instagram-square"></i>
                                                    @break
                                                @case('Youtube')
                                                    <i class="s-icon fab fa-youtube"></i>
                                                    @break
                                                @case('Tiktok')
                                                    <i class="s-icon fab fa-tiktok"></i>
                                                    @break
                                                @default
                                                    
                                            @endswitch
                                    </div>
                                    <div class="mb-2 col">
                                        <input name="social_media[{{$item->name}}][link]" type="text" class="form-control {{ $item->id == 4?'required2':'' }}" placeholder="{{ trans('messages.frontEnd.account_link') }}" aria-label="Username" aria-describedby="basic-addon">
                                        <input name="social_media[{{$item->name}}][type]" type="hidden" class="form-control {{ $item->id == 4?'required2':'' }}" value="{{ $item->id }}" >
                                    </div>
                                  
                                    <div>
                                        <input hidden name="social_media[{{ $item->name }}][type]" value="{{ $item->id }}" type="text" class="ml-2 form-control {{ $item->id == 4?'required2':'' }}" placeholder="subscirbers" aria-label="subscirbers" aria-describedby="basic-addon1">
                                    </div>
                                    </div>  
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <button id="sumbitForm" type="button" class="btn btn-primary" style="background-color: #8e8ab0; border-color:#8e8ab0;">
                        {{  trans('messages.frontEnd.send') }}
                    </button>



                   

                </div>
             </div>
          </div>
        </div>
    </div>
  </section>
 </form>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
 @php
 $token = Cookie::get('jwt_token');
 @endphp
 


<script>
         
    $('#tax_value').hide();
    $('#cr_no_note').hide();
  $('#show_marou_num').click(function(){
    $('#add_marof_numbe').show();
    $('#add_cr_document_label').hide();
  });
  $('#hide_marou_num').click(function(){
    $('#add_marof_numbe').hide();
    $('#add_cr_document_label').show();
  });


  $('#show_tax_value').click(function(){
    $('#tax_value').show();
    $('#cr_no_note').hide();
  });
  $('#show_tax_value').trigger('click');

  $('#hide_tax_value').click(function(){
    $('#tax_value').hide();
    $('#cr_no_note').show();
  });
  $('#country_id').change(function(){
      $('#area_id').attr('disabled',false);
      getRegionAccordingToCountry(this.value)
  });
  $('#area_id').change(function(){
        getCityAccordingToRegion(this.value);
  });

  let jwt_token = '{{ $token }}';

  function getRegionAccordingToCountry(country_id)
  {
    let url = '{{ route("regions.index",":id") }}';
    let addCountryId = url.replace(':id',country_id);
    $('#area_id').empty();
    $('#area_id').append("<option>{{ trans('messages.frontEnd.area') }}</option>")
    $('#area_id').attr('disabled',true);

    $('#city_id').empty();
    $('#city_id').append("<option>{{ trans('messages.frontEnd.city') }}</option>")
    $('#city_id').attr('disabled',true);
    $.ajax({
            url:addCountryId,
            type:'GET',
            success:(res)=>{
                console.log('response: ',res);
                if(res.data.length > 0)
                {
                    $('#area_id').empty();
                    $('#area_id').attr('disabled',false);
                    $('#city_id').attr('disabled',false);
                    let data_array = res.data;
                    for (let index = 0; index < data_array.length; index++) {
                        const element = data_array[index];
                        let option = `<option value="${element.id}" >${element.name}</option>`;
                        $('#area_id').append(option);
                    }
                    if(res.data.length == 1)
                    {
                        getCityAccordingToRegion(res.data[0].id);
                    }
                }
                else
                {
                    Swal.fire({
                        title: 'Error!',
                        text:'No regions avalibale',
                        icon: 'error',
                        position:'top-right',
                        toast:true,
                        showConfirmButton:false
                    });
                     return;
                }
            },
            error:(err)=>{
                console.log("error: ",err)
            }
    });

  }

  function getCityAccordingToRegion(region_id)
  {
    let url = '{{ route("cities.getCities",":id") }}';
    let addRegionIdToUrl = url.replace(':id',region_id);
    $.ajax({
            url:addRegionIdToUrl,
            type:'GET',
            success:(res)=>{
                if(res.data.length > 0)
                {
                    $('#city_id').empty();
                    let data_array = res.data;
                    for (let index = 0; index < data_array.length; index++) {
                        const element = data_array[index];
                        let option = `<option value="${element.id}" >${element.name}</option>`;
                        $('#city_id').append(option);
                    }
                }
                else
                {
                    Swal.fire({
                        title: 'Error!',
                        text:'No cities avalibale',
                        icon: 'error',
                        position:'top-right',
                        toast:true,
                        showConfirmButton:false
                    });
                     return;
                }
            },
            error:(err)=>{
                console.log("error: ",err)
            }
    });

  }

  $('#sumbitForm').click(()=>{
      let budget = document.getElementById('budget').value;
        if(!valdation())return;
        let checkNumber = Math.round(1000 / budget) / (1 / budget) === 1000;
        if(!checkNumber){
        Swal.fire({
            title: 'Valdation Error!',
            text:'budget must be a multiple of thousands',
            icon: 'error',
            position:'top-right',
            toast:true,
            showConfirmButton:false
        });
           return false;
       }
        const formData = new FormData(document.getElementById('storeForm'));
        $.ajax({
            url:'{{route("storeAdApi")}}',
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            beforeSend: function (xhr) {
                 xhr.setRequestHeader('Authorization', `${jwt_token}`);
            },
            type:'POST',
            data:formData,
            success:(res)=>{
                if(res.status == 201)
                {
                    Swal.fire({
                            title: res.msg,
                            icon: 'success',
                            position:'top-right',
                            toast:true,
                            showConfirmButton:false
                    });
                    window.location.href = "{{ route('customers.index') }}";
                }
                else
                {
                    Swal.fire({
                            title: 'Something wrong!',
                            icon: 'error',
                            position:'top-right',
                            toast:true,
                            showConfirmButton:false
                    });
                }
            },
            error:(err)=>{
                if(err.status == 422)
                {

                    Swal.fire({
                            title: 'Valdation Error!',
                            text:err.err,
                            icon: 'error',
                            position:'top-right',
                            toast:true,
                            showConfirmButton:false
                    });
                }
                else
                {
                    Swal.fire({
                            title: 'Server Error!',
                            text:'',
                            icon: 'error',
                            position:'top-right',
                            toast:true,
                            showConfirmButton:false
                    });
                }
            }
        });

       

    // $("#storeForm").ajaxForm(data);



  })
  function valdation()
    {
        let page_name = `.required:visible`;
        let inputs = $(page_name);
        let errors = [];
                $('.error-validation').remove();
                let valid = true; 
                for(var i = 0; i < inputs.length;i++){
                    if(!$(inputs[i]).val()){
                        $(inputs[i]).closest('.form-group').append(`<p class="w-100 mb-0 error-validation text-danger">This field is required</p>`);
                       // errors.push($(inputs[i]).attr('id'));
                        $(inputs[i]).addClass('danger-border');
                        valid = false;
                    }else
                    {
                        $(inputs[i]).removeClass('danger-border');
                    }
                }
                if(!valid){
              
                    Swal.fire({
                            title: 'Please fill the required field!',
                            icon: 'error',
                            toast:true,
                            position:'top-right',
                            showConfirmButton:false,
                            timer: 3000,
                        })
                        return valid;

                }

                return true;
    }

    var loadFile = function(event) {
            var image = document.getElementById('user-image');
            let supported_file_types = ['jpeg','png','jpg','png'];
            let current_file_type = event.target.files[0].type.split("/");
            if(!supported_file_types.includes(current_file_type[1]))
            {
                Swal.fire({
                        title: 'Valdation Error!',
                        text:'file is not supported, supported file types('+ supported_file_types.toString() +')',
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false

                    })
                    document.getElementById('fileinput').value = '';
                return;
            }
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $('#country_id').val(199).trigger('change');

     
        $('input#budget').on("change", function (last) {
            return function() {
                if (+$(this).val() > 1000) {
                    $("#budget").attr('step', 1000);
                    $("#budget").attr('min', 0);
                    this.value = last === 1000 && +this.value === 600
                        ? 1000
                        : Math.round(this.value / 1000) * 1000;
                } else {
                    $("#budget").attr('step', 1000);
                    $("#budget").attr('min', 1000);
                    this.value = Math.max(1000, Math.round(this.value / 100) * 100);
                }
                last = +this.value;
        };
}(0));



</script>


@endsection