<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar'?'rtl':'ltr' }}" lang="{{ app()->getLocale() }}" >
  <head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap && Css -->
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/telphone/css/intlTelInput.css') }}">
  </head>
  <!-- All Images In Regular Size Are Hidden For Responsive Size (600 / 990) -->

  <style>
      .label-advertiser{
          font-weight: bold;
      }
      .input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
}
.s-icon{
    font-size: 25px;
    color: #9686aa;
    margin-right: 12px;
}
.danger-border{
    border-color: red;
}
.iti--allow-dropdown{
    display: block;
}
  </style>

  <body class="body">
    <!-- menu section -->
   
      <!-- end menu section -->
      <section class="background-page7 position-relative d-flex align-items-center py-5">
        <div class="container">
           <div class="row">
               <form method="post" id="add_form" enctype="multipart/form-data" class="login-adv p-md-5">
                   <div class="left-path text-center">
                       <img src="{{ asset('frontEnd/img/Path 143035.png') }}" alt="" height="100px" width="250px">
                   </div>
                   <div class="left-snapchat text-center">
                    <img src="{{ asset('frontEnd/img/Icon awesome-snapchat.png') }}" alt="" height="150px" width="150px">
                </div>
                    <div class="container">

                        <div class="text-center">
                            <img id="user-image" height="160px" width="155px" class="back-ground-advertiser rounded-circle" src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt="">
                            <input name="image" onchange="loadFile(event)" class="file-input required1" style="display: none;" id="fileinput" type="file" />
                        </div>
                        <h3 class="mt-3 text-center" id="section_title">{{ trans('messages.frontEnd.influencer_information') }}</h3>
                        

                        {{-- Influencer information --}}

                        <section id="page_number_1">
                            <div class="row input-adv mt-5">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="first_name" class="mb-1 float-left label-advertiser ">{{ trans('messages.frontEnd.first_name') }}</label>
                                    <input name="first_name" id="first_name" type="text" class="form-control required1" placeholder="{{ trans('messages.frontEnd.first_name') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="miggle_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.middle_name') }}</label>
                                    <input name="middle_name" id="middle_name" type="text" class="form-control required1" placeholder="{{ trans('messages.frontEnd.middle_name') }}">
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="last_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.last_name') }}</label>
                                    <input name="last_name" id="last_name" type="text" class="form-control required1" placeholder="{{ trans('messages.frontEnd.last_name') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="gender" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.gender') }}</label>
                                    <select name="gender" class="form-control required1" id="gender" >
                                        <option value="Male" >Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="nationality" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.nationality') }}</label>
                                    <select name="nationality_id" class="form-control required1" id="nationality_id" >
                                        @foreach ($nationality as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="countries" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.countries') }}</label>
                                    <select name="country_id" onchange='getRegionAccordingToCountry()' class="form-control required1" id="country_id" >
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mt-3">
                                        <label for="country_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.country_code') }}</label>
                                        <input name="country_code" id="country_code" type="tel" class="form-control required1" placeholder="{{ trans('messages.frontEnd.country_code') }}">
                                    </div>
        
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mt-3">
                                        <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.id_number') }}</label>
                                        <input name="id_number" id="id_number" type="number" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.id_number') }}">
    
                                    </div>
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="region_id" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.region') }}</label>
                                    <select  name="region_id" onchange='getCityAccordingToRegion()' id="region_id" class="form-control required1">
                                    </select>
                                </div>
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="city" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.city') }}</label>
                                     <select id="city_id" class="form-control required1"  name="city_id" id="" >
                                    </select>
                                </div>
                            </div>
                            <div class="row input-adv">
                                
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="phone" class="mb-1 d-block label-advertiser">{{ trans('messages.frontEnd.phone') }}</label>
                                    <input name="phone" id="phone" type="tel" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.phone') }}">
                                </div>
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.dial_code') }}</label>
                                    <input name="dial_code" id="dial_code" type="number" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.dial_code') }}">
                                </div>
                                <div class="col  mt-3">
                                    <label for="email" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.mail') }}</label>
                                    <input name="email" id="email" type="email" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.mail') }}">
                                </div>
                            
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="password" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.password') }}</label>
                                    <input name="password" id="password" type="password" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.password') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="password_conformation" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.password_confirm') }}</label>
                                    <input name="password_confirmation" id="password_conformation" type="password" class="form-control required1"  placeholder="{{ trans('messages.frontEnd.password_confirm') }}">
                                </div>
                            </div>
                           

                        </section>
                        <section id="page_number_2">
                            <div class="row input-adv mt-5">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="nick_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.nick_name') }}</label>
                                    <input name="nick_name" id="nick_name" type="text" class="form-control required2" placeholder="{{ trans('messages.frontEnd.nick_name') }}">
                                </div>
                                <div class="col-md-6 col-12  mt-3">
                                    <label for="countries" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.ads_outside') }}</label>
                                    <select name="ads_out_country" class="form-control required2" id="ads_out_country" >
                                        <option value="1">{{ trans('messages.frontEnd.yes') }}</option>
                                        <option value="0">{{ trans('messages.frontEnd.no') }}</option>
                                    </select>
                                </div>
                               
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="category" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.category_type') }}</label>
                                    <select multiple name="categories[]" class="form-control required2" id="categories" style="height: 150px;" >
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="miggle_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.about_me') }}</label>
                                    <textarea name="bio" class="form-control required2" id="bio" name="bio" id="" cols="30" rows="5">
                                    </textarea>
                                </div>
                                
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12">
                                    <div class="mt-3">
                                        <label for="online_ad_price" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.ad_online_price') }}</label>
                                        <input oninput="adPriceWithTax('ad_with_vat',event.target.value)" name="ad_price" id="ad_price" type="number" class="form-control required2" placeholder="{{ trans('messages.frontEnd.ad_online_price') }}">
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-12">
                                    <div class="mt-3">
                                        <label for="online_ad_price_with_tax" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.ad_with_vat') }}</label>
                                        <input  readonly="readonly" name="ad_with_vat" id="ad_with_vat" type="number" class="form-control required2" placeholder="{{ trans('messages.frontEnd.ad_with_vat') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mt-3">
                                        <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.ad_price') }}</label>
                                        <input oninput="adPriceWithTax('ad_onsite_price_with_vat',event.target.value)" name="ad_onsite_price" id="ad_onsite_price" type="number" class="form-control required2"  placeholder="{{ trans('messages.frontEnd.ad_price') }}">
                                    </div>
                                </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mt-3">
                                            <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.ad_onsite_price_with_vat') }}</label>
                                            <input  readonly="readonly" name="ad_onsite_price_with_vat" id="ad_onsite_price_with_vat" type="number" class="form-control required2"  placeholder="{{ trans('messages.frontEnd.ad_onsite_price_with_vat') }}">
                                        </div>
                                    </div>
                              
                            </div>
                          
                            
                                <div class="form-group mt-4">
                                    <label class="mb-2" for="inputAddress2">{{ trans('messages.frontEnd.your_account_media') }}</label>
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
                                                <div class="mb-2">
                                                    <input name="social_media[{{$item->name}}][link]" type="text" class="form-control {{ $item->id == 4?'required2':'' }}" placeholder="{{ trans('messages.frontEnd.username') }}" aria-label="Username" aria-describedby="basic-addon">
                                                    <input name="social_media[{{$item->name}}][type]" type="hidden" class="form-control {{ $item->id == 4?'required2':'' }}" value="{{ $item->id }}" >
                                                </div>
                                                <div>
                                                    <input name="social_media[{{ $item->name }}][subscribers]" type="number" class="ml-2 form-control {{ $item->id == 4?'required2':'' }}" placeholder="{{ trans('messages.frontEnd.subscibers') }}" aria-label="subscirbers" aria-describedby="basic-addon">
                                                </div>
                                                <div>
                                                    <input hidden name="social_media[{{ $item->name }}][type]" value="{{ $item->id }}" type="text" class="ml-2 form-control {{ $item->id == 4?'required2':'' }}" placeholder="subscirbers" aria-label="subscirbers" aria-describedby="basic-addon1">
                                                </div>
                                                </div>  
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                               
                        </section>
                        <section id="page_number_3">
                            <div class="row input-adv mt-5">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="rep_full_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.representer_full_name') }}</label>
                                    <input name="rep_full_name" id="full_name_for" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.representer_full_name') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="miggle_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.rep_phone_number') }}</label>
                                    <input name="rep_phone_number" id="rep_phone_number" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.rep_phone_number') }}">
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="rep_city" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.city') }}</label>
                                    <input name="rep_city" id="rep_city" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.city') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="street" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.street') }}</label>
                                    <input name="street" id="street" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.street') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="rep_area" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.region') }}</label>
                                    <input name="rep_area" id="rep_area" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.region') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="milestone" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.milestone') }}</label>
                                    <input name="milestone" id="milestone" type="text" class="form-control required3" placeholder="{{ trans('messages.frontEnd.milestone') }}">
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col">
                                    <div class="mt-3">
                                        <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.neighborhood') }}</label>
                                        <input name="neighborhood" id="neighborhood" type="text" class="form-control required3"  placeholder="{{ trans('messages.frontEnd.neighborhood') }}">
    
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="page_number_4">
                            <div class="row input-adv mt-5">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="bank_account_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.bank_account_name') }}</label>
                                    <input name="bank_account_name" id="bank_account_name" type="text" class="form-control required4" placeholder="{{ trans('messages.frontEnd.bank_account_name') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="miggle_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.bank') }}</label>
                                    <select name="bank_id" class="form-control required4" id="bank_id" >
                                        @foreach ($banks as $item)
                                        <option value="{{$item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row input-adv">
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="bank_account_number" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.iban_number') }}</label>
                                    <input name="bank_account_number" id="bank_account_number" type="text" class="form-control required4" placeholder="{{ trans('messages.frontEnd.iban_number') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="bank_account_number_confirm" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.iban_number_con') }}</label>
                                    <input name="bank_account_number_confirm" id="bank_account_number_confirm" type="text" class="form-control required4" placeholder="{{ trans('messages.frontEnd.iban_number_con') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="commercial_registration_no" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.cr_number') }}</label>
                                    <input name="commercial_registration_no" id="commercial_registration_no" type="text" class="form-control required4" placeholder="{{ trans('messages.frontEnd.cr_number') }}">
                                </div>
                                <div class="col-md-6 col-12 mt-3">
                                    <label for="milestone" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.are_you_subjected_to_added_value_vat') }}</label>
                                    <select name="is_vat" class="form-control required4" id="is_vat" >
                                        <option value="1">{{ trans('messages.frontEnd.yes') }}</option>
                                        <option value="0">{{ trans('messages.frontEnd.no') }}</option>
                                    </select>
                                </div>
                                <div class="col mt-3">
                                    <label for="milestone" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.upload_your_cr_document') }}</label>
                                    <input name="cr_file" id="cr_file" type="file" class="form-control required4" placeholder="{{ trans('messages.frontEnd.upload_your_cr_document') }}">
                                </div>
                            </div>
                         
                          
                           
                        </section> 
                        <div class="right-facebook">
                            <img src="{{ asset('frontEnd/img/Group 55637.png') }}" alt="" width="200px" height="200px">
                        </div>
                   
                        <div class="row">
                            
                           
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="form-check input-adv p-0">
                                   <button id="nextButton" onclick="changePage()" type="button"  class="btn btn-none form-control">{{ trans('messages.frontEnd.next') }}</button>
                                   <button id="submitButton"  type="submit"  class="btn btn-none form-control">{{ trans('messages.frontEnd.finish') }}</button>
                                   <button id="backButtonButton" onclick="goBackOnePage()" type="button"  class="btn btn-none form-control mt-2">{{ trans('messages.frontEnd.back') }}</button>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-md-6 col-12 input-adv mt-3">
                                <p class="text-center">{{ trans('messages.frontEnd.do_you_have_an_account') }} ?  <a href="{{ route('auth.login') }}">{{ trans('messages.frontEnd.login') }}</a> </p>
                            </div>
                           
                        </div>

                        <div class="left-instagram">
                            <img src="{{ asset('frontEnd/img/Icon awesome-instagram.png') }}" alt="" width="150px" height="150px">
                        </div>
                    </div>
               </form>
               
           </div>
        </div>
      
    </section>
 
 
      <!-- Footer -->
     
      <!-- End Footer -->
     <!--JAVASCRIPT-->
     <script type='text/javascript' src='{{ asset('frontEnd/js/jquery-3.6.0.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/bootstrap.min.js') }}'></script>
     <script type="text/javascript" src="{{ asset('frontEnd/telphone/js/intlTelInput-jquery.js') }}"></script>
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <!--End JAVASCRIPT-->
​
 </body>
</html>


<script>
        $('#page_number_2').hide();
        $('#page_number_3').hide();
        $('#page_number_4').hide();
        $('#submitButton').hide();

        let object_titles = {
            'page_number_1':'{{ trans("messages.frontEnd.influencer_information") }}',
            'page_number_2':'{{ trans("messages.frontEnd.media_information") }}',
            'page_number_3':'{{ trans("messages.frontEnd.delivery_address_information") }}',
            'page_number_4':'{{ trans("messages.frontEnd.bank_and_commercial_information") }}',
        };
        let last_page_number =  4;
    document.getElementById('city_id').value = '';
            $( "#user-image" ).click(function() {
                $('#fileinput').trigger('click'); 
            });
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
                        showConfirmButton:false,
                        timer: 10000,

                    })
                    document.getElementById('fileinput').value = '';
                return;
            }
            image.src = URL.createObjectURL(event.target.files[0]);
        };


    let count_countries = '{{ count($countries) }}';
    if(count_countries > 0)
    {
        getRegionAccordingToCountry('{{ $countries[0]->id }}')
    }
    $('#region_id').attr("disabled", 'disabled');

    $('#add_form').submit(function(e) {

       e.preventDefault();
       console.log(this)
       let formData = new FormData(document.getElementById('add_form'));

       let url = '{{ route("register_influencer") }}';

       $.ajax({
            url:url,
            type:'POST',
            data:formData,
            enctype: 'multipart/form-data',
            cache:false,
                contentType: false,
                processData: false,
            success:(res)=>{
                if(res.status == 201)
                {
                   window.location.replace("{{ route('auth.active_code') }}");
                }
            },
            error:(err)=>{
                if(err.responseJSON.status == 422)
                {
                    Swal.fire({
                        title: 'Valdation Error!',
                        text:err.responseJSON.err,
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false,
                        timer: 10000,
                    })

                }
                else
                {
                    Swal.fire({
                            title: 'Server Error!',
                            icon: 'error',
                            toast:true,
                            position:'top-right',
                            showConfirmButton:false,
                            timer: 10000,
                        })

                }


            }
        });
  });

   

    function getRegionAccordingToCountry()
    {
        let country_id = document.getElementById('country_id').value;
        let url = '{{ route("regions.index",":id") }}';
        let addIdToUrl = url.replace(':id',country_id);
        $.ajax({
            url:addIdToUrl,
            type:'GET',
            success:(res)=>{
                $('#region_id').empty();
                $('#city_id').empty();

                if(res.data.length == 0){
                    $('#region_id').attr("disabled", 'disabled');
                }
                else
                {
                    $('#region_id').removeAttr("disabled");
                }
                for (let index = 0; index < res.data.length; index++) {
                    const element = res.data[index];
                    let option_element = `<option value="${element.id}" >${element.name}</option>`;
                    $('#region_id').append(option_element);
                }
                if(res.data.length == 1)
                {
                    document.getElementById('region_id').value =  res.data[0].id;
                    getCityAccordingToRegion()
                }
                if(res.data.length == 0)
                {
                    Swal.fire({
                        title: 'ُError!',
                        text:'No data to country',
                        icon: 'error',
                        position:'top-right',
                        toast:true,
                        showConfirmButton:false,
                        timer: 10000,
                    })
                }
            },
            error:(err)=>{}
        })
    }

    function getCityAccordingToRegion()
    {
        let region_id = document.getElementById('region_id').value;
        let url = '{{ route("cities.getCities",":id") }}';
        let addIdToUrl = url.replace(':id',region_id);
        $.ajax({
            url:addIdToUrl,
            type:'GET',
            success:(res)=>{
                $('#city_id').empty();

                if(res.data.length == 0){
                    $('#city_id').attr("disabled", 'disabled');
                }
                else
                {
                    $('#city_id').removeAttr("disabled");
                }
                for (let index = 0; index < res.data.length; index++) {
                    const element = res.data[index];
                    let option_element = `<option value="${element.id}" >${element.name}</option>`;
                    $('#city_id').append(option_element);
                }

                if(res.data.length == 0)
                {
                    Swal.fire({
                        title: 'Erro!',
                        text:'No data to region',
                        icon: 'error',
                        position:'top-right',
                        toast:true,
                        showConfirmButton:false,
                        timer: 10000,
                    })
                }
                
            },
            error:(err)=>{}
        })
    }


    
    let current_page = 1;
    $("#backButtonButton").attr("disabled","disabled");
    function changePage()
    {
        /** Valdation **/

      if(!valdation(current_page))return;

      let checkUniqeDataRequest  = '{{ route("checkUniqueData") }}';
    $.ajax({
        url:checkUniqeDataRequest,
        type:'POST',
        data:{
            email:document.getElementById('email').value,
            phone:document.getElementById('phone').value,
        },
        success:(res)=>{
            if(res.status == 200)
            {
                 /** PLUS THE CURRENT PAGE **/
          current_page = current_page + 1
        /** REMOVE THE SECTION TITLE TO ADD NEW ONE **/
        $('#section_title').empty();
       
        /** GET THE CURRENT PAGE TITLE AND ADDIT TO THE SECTION **/
        let current_page_title = 'page_number_'+current_page;
        console.log('current page: '+current_page)
        console.log('current page title: '+current_page_title)
        $('#section_title').append(object_titles[current_page_title]);

        $("#backButtonButton").attr("disabled",false);
        /** HIDE ALL THE PREVIOUS PAGES **/
            for (let index = 1; index <= last_page_number; index++) {
                if(index != current_page+1)
                {
                    $('#page_number_'+index).hide();
                } 
            }
        /** IF THE CURRENT PAGE IS MORE OR EQUAL TO THE LAST PAGE MAKE THE BUTTON FINSHED **/
           if(current_page >= last_page_number)
           {
                    $('#nextButton').hide();
                    $('#submitButton').show();

                    $('#page_number_'+current_page).show();
           }
        /** SHOW THE CURRENT PAGE **/
           $('#page_number_'+current_page).show();
            }
            else
            {
                Swal.fire({
                        title: 'Valdation Error!',
                        text:res.msg,
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false,
                        timer: 10000,

                    })
            }
        },
        error:(err)=>{
            console.log(err)
            Swal.fire({
                        title: 'Valdation Error!',
                        text:err.responseJSON.msg,
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false,
                        timer: 10000,

                    })
        },
    })
     

         
    }

    function adPriceWithTax(id,value)
    {
        let tax = '{{ $tax_num }}';
        let num_with_number = tax/100 * value;
        console.log('value: ',value)
        let fullValue = parseFloat(num_with_number) + parseFloat(value);
        console.log('wit tax: ',num_with_number)

        document.getElementById(id).value = fullValue;
    }
    
    function goBackOnePage()
    {
        
        $('#nextButton').show();
        $('#submitButton').hide();


        if(current_page != 1)
        {
            current_page = current_page - 1
        }
        else
        {
            $("#backButtonButton").attr("disabled","disabled");
        };
       

         /** REMOVE THE SECTION TITLE TO ADD NEW ONE **/
         $('#section_title').empty();
       
       /** GET THE CURRENT PAGE TITLE AND ADDIT TO THE SECTION **/
       let current_page_title = 'page_number_'+current_page;
       $('#section_title').append(object_titles[current_page_title]);

          /** HIDE ALL THE PREVIOUS PAGES **/
          for (let index = 0; index <= last_page_number; index++) {
                if(index != current_page-1)
                {
                    $('#page_number_'+index).hide();
                } 
            }
        /** IF THE CURRENT PAGE IS MORE OR EQUAL TO THE LAST PAGE MAKE THE BUTTON FINSHED **/
           if(current_page >= last_page_number)
           {
                    $('#nextButton').empty();
                    $('#nextButton').append('Finish');
                    $("#nextButton").removeAttr("type").attr("type", "submit"); 
                    $('#page_number_'+current_page).show();
           }
        /** SHOW THE CURRENT PAGE **/
           $('#page_number_'+current_page).show();
    }

    function valdation(page_number)
    {
        if(page_number == 2)
        {
           let count_category =  $("select#categories option:selected[value!='']").length;
           if(count_category != 3)
           {
               Swal.fire({
                                title: 'you should choose 3 category',
                                icon: 'error',
                                toast:true,
                                position:'top-right',
                                showConfirmButton:false,
                                timer: 10000,
                            })
            return false;
           }
        }
        let page_name = `.required${page_number}:visible`;
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
                            timer: 10000,
                        })
                        return valid;

                }

                return true;
    }
    
    var input = document.querySelector("#telephone");

    $("#phone").intlTelInput({
        utilsScript: '{{ asset("frontEnd/telphone/js/utils.js") }}',
        preferredCountries: ["sa","jo" ],

    });

 

</script>
