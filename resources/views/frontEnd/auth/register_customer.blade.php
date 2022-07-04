<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar'?'rtl':'ltr' }}" lang="{{ app()->getLocale() }}">
  <head>
    <title>Al-Muaathir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap && Css -->
    <link rel="stylesheet" href="{{ asset('frontEnd/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontEnd/css/all.min.css') }}">
  </head>
  <!-- All Images In Regular Size Are Hidden For Responsive Size (600 / 990) -->

  <style>
      .label-advertiser{
          font-weight: bold;
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
                            <input name="image" onchange="loadFile(event)" class="file-input" style="display: none;" id="fileinput" type="file" />
                        </div>
                        <h3 class="mt-3 text-center ">{{ trans('messages.frontEnd.advertiser_information') }}</h3>
                        <div class="row input-adv mt-5">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="first_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.first_name') }}</label>
                                <input name="first_name" id="first_name" type="text" class="form-control" placeholder="{{ trans('messages.frontEnd.first_name') }}">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="miggle_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.middle_name') }}</label>
                                <input name="middle_name" id="middle_name" type="text" class="form-control" placeholder="{{ trans('messages.frontEnd.middle_name') }}">
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="last_name" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.last_name') }}</label>
                                <input name="last_name" id="last_name" type="text" class="form-control" placeholder="{{ trans('messages.frontEnd.last_name') }}">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="gender" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.gender') }}</label>
                                <select name="gender" class="form-control" id="gender" >
                                    <option value="Male" >{{ trans('messages.frontEnd.male') }}</option>
                                    <option value="Female">{{ trans('messages.frontEnd.female') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="nationality" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.nationality') }}</label>
                                <select name="nationality_id" class="form-control" id="nationality_id" >
                                    @foreach ($nationality as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="countries" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.countries') }}</label>
                                <select name="country_id" onchange='getRegionAccordingToCountry()' class="form-control" id="country_id" >
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-3">
                                    <label for="country_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.country_code') }}</label>
                                    <input name="country_code" id="country_code" type="number" class="form-control" placeholder="{{ trans('messages.frontEnd.country_code') }}">
                                </div>
    
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-3">
                                    <label for="dial_code" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.dial_code') }}</label>
                                    <input name="dial_code" id="dial_code" type="text" class="form-control" placeholder="{{ trans('messages.frontEnd.dial_code') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="right-facebook">
                            <img src="{{ asset('frontEnd/img/Group 55637.png') }}" alt="" width="200px" height="200px">
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="countries" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.region') }}</label>
                                <select  name="region_id" onchange='getCityAccordingToRegion()' id="region_id" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="city" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.city') }}</label>
                                <select id="city_id" class="form-control"  name="city_id" id="" >
                                </select>
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="email" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.mail') }}</label>
                                <input name="email" id="email" type="email" class="form-control"  placeholder="{{ trans('messages.frontEnd.mail') }}">
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="phone" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.phone') }}</label>
                                <input name="phone" id="phone" type="number" class="form-control"  placeholder="{{ trans('messages.frontEnd.phone') }}">
                            </div>
                        
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="password" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.password') }}</label>
                                <input name="password" id="password" type="password" class="form-control"  placeholder="{{ trans('messages.frontEnd.password') }}">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="password_conformation" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.password_confirm') }}</label>
                                <input name="password_confirmation" id="password_conformation" type="password" class="form-control"  placeholder="{{ trans('messages.frontEnd.password_confirm') }}">
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col mt-3">
                                <label for="id_number" class="mb-1 float-left label-advertiser">{{ trans('messages.frontEnd.id_number') }}</label>
                                <input name="id_number" id="id_number" type="number" class="form-control"  placeholder="{{ trans('messages.frontEnd.id_number') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" required type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label label-adv" for="flexRadioDefault1">
                                        {{ trans('messages.frontEnd.i_agree_with_terms_and_conditions') }}
                                    </label>
                                  </div>
                            </div>
                           
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="form-check input-adv p-0">
                                   <button type="submit"  class="btn btn-none form-control">{{ trans('messages.frontEnd.new_register') }}</button>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-md-6 col-12 input-adv mt-3">
                                <p class="text-center">{{ trans('messages.frontEnd.do_you_have_active_account') }}  <a href="{{ route('auth.login') }}">{{ trans('messages.frontEnd.login') }}</a> </p>
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
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <!--End JAVASCRIPT-->
​
 </body>
</html>


<script>
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
                        showConfirmButton:false

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

       let url = '{{ route("register_customer") }}';

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
                if(err.responseJSON.status == 401 || err.responseJSON.status == 422)
                {
                    Swal.fire({
                        title: 'Valdation Error!',
                        text:err.responseJSON.err,
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false

                    })

                }
                else
                {
                    Swal.fire({
                            title: 'Server Error!',
                            icon: 'error',
                            toast:true,
                            position:'top-right',
                            showConfirmButton:false
                        })

                }


            }
        });
  });

    function sendCreateRequest()
    {
        const form = {
            first_name:document.getElementById('first_name').value,
            middle_name:document.getElementById('middle_name').value,
            phone:document.getElementById('phone').value,
            last_name:document.getElementById('last_name').value,
            id_number:document.getElementById('id_number').value,
            gender:document.getElementById('gender').value,
            nationality_id:document.getElementById('nationality_id').value,
            country_id:document.getElementById('country_id').value,
            region_id:document.getElementById('region_id').value,
            country_code:document.getElementById('country_code').value,
            city_id:document.getElementById('city_id').value,
            email:document.getElementById('email').value,
            password:document.getElementById('password').value,
            dial_code:document.getElementById('dial_code').value,
            password_confirmation:document.getElementById('password_conformation').value,
        }
        let url = '{{ route("register_customer") }}';
        $.ajax({
            url:url,
            type:'POST',
            data:form,
            success:(res)=>{
                if(res.status == 201)
                {
                  //  window.location.replace('')
                }
            },
            error:(err)=>{
                if(err.status == 422)
                {
                    Swal.fire({
                        title: 'Valdation Error!',
                        text:err.responseJSON.err,
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false

                    })

                }
                else
                {
                    Swal.fire({
                            title: 'Server Error!',
                            icon: 'error',
                            toast:true,
                            position:'top-right',
                            showConfirmButton:false
                        })

                }


            }
        });
    }

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
                        title: 'Erro!',
                        text:'No data to country',
                        icon: 'error',
                        position:'top-right',
                        toast:true,
                        showConfirmButton:false
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
                        showConfirmButton:false
                    })
                }
                
            },
            error:(err)=>{}
        })
    }
    

</script>
