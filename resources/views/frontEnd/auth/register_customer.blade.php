<!DOCTYPE html>
<html>
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
               <form class="login-adv p-md-5">
                   <div class="left-path text-center">
                       <img src="{{ asset('frontEnd/img/Path 143035.png') }}" alt="" height="100px" width="250px">
                   </div>
                   <div class="left-snapchat text-center">
                    <img src="{{ asset('frontEnd/img/Icon awesome-snapchat.png') }}" alt="" height="150px" width="150px">
                </div>
                    <div class="container">
                        <div class="text-center">
                            <img class="back-ground-advertiser" src="{{ asset('frontEnd/img/young-pretty-girl-smiling-cheerfully-casually-with-positive-happy-confident-relaxed-expression.png') }}" alt="">
                        </div>
                        <h3 class="mt-3 text-center ">Advertiser information</h3>
                        <div class="row input-adv mt-5">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="first_name" class="mb-1 float-left label-advertiser">First name</label>
                                <input id="first_name" type="text" class="form-control" placeholder="please add first name">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="miggle_name" class="mb-1 float-left label-advertiser">Middle name</label>
                                <input id="middle_name" type="text" class="form-control" placeholder="please add middle name">
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="last_name" class="mb-1 float-left label-advertiser">Last name</label>
                                <input id="last_name" type="text" class="form-control" placeholder="please add last name">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="gender" class="mb-1 float-left label-advertiser">Gender</label>
                                <select class="form-control" id="gender" >
                                    <option value="Male" >Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="nationality" class="mb-1 float-left label-advertiser">Nationality</label>
                                <select class="form-control" id="nationality_id" >
                                    @foreach ($nationality as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="countries" class="mb-1 float-left label-advertiser">Countries</label>
                                <select onchange='getRegionAccordingToCountry()' class="form-control" id="country_id" >
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt3">
                            <label for="country_code" class="mb-1 float-left label-advertiser">Country code</label>
                            <input id="country_code" type="text" class="form-control" placeholder="please add country code">
                        </div>
                        <div class="right-facebook">
                            <img src="{{ asset('frontEnd/img/Group 55637.png') }}" alt="" width="200px" height="200px">
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="countries" class="mb-1 float-left label-advertiser">Region</label>
                                <select  onchange='getCityAccordingToRegion()' id="region_id" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="city" class="mb-1 float-left label-advertiser">City</label>
                                <select id="city_id" class="form-control"  name="" id="" >
                                </select>
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12  mt-3">
                                <label for="email" class="mb-1 float-left label-advertiser">Email</label>
                                <input id="email" type="email" class="form-control"  placeholder="Email">
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <label for="phone" class="mb-1 float-left label-advertiser">Phone</label>
                                <input id="phone" type="number" class="form-control"  placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="row input-adv">
                            <div class="col-md-6 col-12 mt-3">
                                <label for="password" class="mb-1 float-left label-advertiser">Password</label>
                                <input id="password" type="password" class="form-control"  placeholder="Password">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <label for="password_conformation" class="mb-1 float-left label-advertiser">Password Conformation</label>
                                <input id="password_conformation" type="password" class="form-control"  placeholder="Re-Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" required type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label label-adv" for="flexRadioDefault1">
                                        I agree with terms and conditions
                                    </label>
                                  </div>
                            </div>
                           
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="form-check input-adv p-0">
                                   <button type="button" onclick="sendCreateRequest()" class="btn btn-none form-control"> Sing Up</button>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-md-6 col-12 input-adv mt-3">
                                <p class="text-center">Do you have an account?  <a href="">Log in</a> </p>
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
    let count_count = '{{ count($countries) }}';
    if(count_count > 0)
    {
        getRegionAccordingToCountry('{{ $countries[0]->id }}')
    }
    $('#region_id').attr("disabled", 'disabled');
    function sendCreateRequest()
    {
        const form = {
            first_name:document.getElementById('first_name').value,
            middle_name:document.getElementById('middle_name').value,
            phone:document.getElementById('phone').value,
            last_name:document.getElementById('last_name').value,
            gender:document.getElementById('gender').value,
            nationality:document.getElementById('nationality_id').value,
            country_id:document.getElementById('country_id').value,
            region_id:document.getElementById('region_id').value,
            country_code:document.getElementById('country_code').value,
            city_id:document.getElementById('city_id').value,
            email:document.getElementById('email').value,
            password:document.getElementById('password').value,
            password_confirmation:document.getElementById('password_conformation').value,
        }
        let url = '{{ route("register_customer") }}';
        $.ajax({
            url:url,
            type:'POST',
            data:form,
            success:(res)=>{},
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
