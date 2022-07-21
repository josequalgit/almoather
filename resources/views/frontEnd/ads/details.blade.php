@extends('frontEnd.layouts.index')

@section('content')
<style>

 .title {
    font-weight: bolder;
    font-size: 18px;
}
.fab {
    font-size: 1rem;
}
</style>
<section  class="section-contract" style="background-image: url('{{ asset('frontEnd/img/Rectangle%2016355.png') }}')">

    <form style="display: none;" method="POST" id="paymentRequest" action="{{ route('send_payment') }}">
        @csrf
        <input type="text" name="ad_id" id="ad_id" hidden/>
        <input type="text" name="amount" id="amount" hidden />
    </form>

    <div class="min-height-100">
        <div class="container">


            <div class='logo section mt-5 d-flex justify-content-center'>
                <img class="w-75" id="logo" src=""/>
            </div>
            <div class="title-section mt-5">
                <h3 id="store" class="text-center">
                </h3>
            </div>
            
                <div class="card w-75 m-auto align-items-center p-3">
                        <div class="row d-flex flex-wrap align-items-center ">
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tax Record No: <span id="tax_number"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Relationship with brand: <span id="relation"></span></label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Campaign Goals: <span id="goal"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Location: <span id="location"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Budget: <span id="budget"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Marouf Number: <span id="marouf_num"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Number of tax: <span id="tax_value"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Store Link: <span id="store_link"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">From: <span id="from"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-6 mx-auto">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">To: <span id="to"></span></label>
                                </div>
                            </div>
                    </div>
                </div>
                <div id="customer_action_area" class="text-center">
                    <button id="customer_action_button" class="btn btn-primary mt-2 w-25"></button>   
                </div>
                <div id="social-media" class="row mt-4"></div>
                <div class="mt-5 card w-75 m-auto align-items-center ">
                    <div class="col mt-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><p class="title">About Ad</p></span></label>
                        </div>
                    </div>
                    <div class="row d-flex flex-wrap align-items-center p-3">
                         <p id="about_ad">
                             
                         </p>                        
                </div>
                
            </div>
            <div class="mt-5 card w-75 m-auto align-items-center ">
                <div class="col mt-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1 "><p class="title">About brand</p></span></label>
                    </div>
                </div>
                <div class="row d-flex flex-wrap align-items-center p-3">
                     <p id="about_brand">
                         
                     </p>                        
            </div>
            
            
        </div>
        <div id="influencer_list" class="mt-5 p-1 card w-75 m-auto align-items-center ">
            
        </div>
        <div class="text-center mt-2">
            <button onclick="getCustomerContract()" class="btn btn-primary" id="fullPaymentButton">Contract & Payment</button>
            <button  id="confirmListButton" onclick="confirmList()" class="btn btn-success w-50">Confirm List</button>
        </div>

     

        <div class="mt-5 card w-75 m-auto align-items-center ">
            <div class="col mt-2">
                <div class="form-group">
                    <label for="exampleInputEmail1"><p class="title">Videos</p></span></label>
                </div>
            </div>
            <div id="videos" class="row d-flex flex-wrap ">
               
                
                                     
        </div>
        
        
    </div>
        <div class="mt-5 card w-75 m-auto align-items-center ">
            <div class="col mt-2">
                <div class="form-group">
                    <label for="exampleInputEmail1"><p class="title">Images</p></span></label>
                </div>
            </div>
            <div id="images" class="row d-flex flex-wrap ">
               
                
                                     
        </div>
        
        
    </div>

    <div id="notChoosenInfluncersModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Influncers</h5>
            </div>
            <div class="modal-body">
                <ul id="influncer_list" class="list-group list-group-light p-2">
           
                  </ul>
                  
            </div>
            <div class="modal-footer">
              <button onclick="closeModal('notChoosenInfluncersModal')" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
               
                    
    

        </div>
    </div>

    <div id="userDetails" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">User Details</h5>
              {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> --}}
            </div>
            <div class="modal-body">
         
                {{-- /**  start  **// --}}


                <div class="card" style="border-radius: 15px;">
                    <div class="card-body text-center">
                      <div class="mt-3 mb-4">
                        <img id="avatar" src=""
                          class="rounded-circle img-fluid" style="width: 100px;" />
                      </div>
                      <h4 id="user_name" class="mb-2">Julie L. Arsenault</h4>
                      <p id="user_location" class="text-muted mb-4">@Programmer</p>
                      <div id="social_media" class="mb-4 pb-2">
                        <a href="" class="btn btn-outline-primary btn-floating">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="" type="button" class="btn btn-outline-primary btn-floating">
                          <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" type="button" class="btn btn-outline-primary btn-floating">
                          <i class="fab fa-skype"></i>
                        </a>
                      </div>
                      {{-- <button type="button" class="btn btn-primary btn-rounded btn-lg">
                        Message now
                      </button> --}}
                      <div class="d-flex justify-content-between mt-5 mb-2">
                            <p id="bio" class="text-center">
                            </p>
                      </div>
                      <label class="mt-3"><h5 class="text-bold">Categories</h5></label>
                      <hr/>
                      <div id="categories_modal" class="row">
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                          <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-info"> <span class="badge">Categories</span></button>
                          </div>
                      </div>
                      <label class="mt-3"><h5 class="text-bold media_details">Media Details</h5></label>
                      <hr class="media_details"/>
                      <div id="media_modal" class="row">
                     
                      </div>
                    </div>


                {{-- /**  end  **// --}}

                  
            </div>
            <div class="modal-footer">
              <button onclick="closeModal('userDetails')" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>


  
      
</section>

<div id="contractData" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        
        <div class="modal-body p-0">
            <embed src="http://www.africau.edu/images/default/sample.pdf" frameborder="0" width="100%" height="600px">
        </div>
        <div class="modal-footer">
            <button onclick="closeModal('contractData')" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button onclick="acceptAdContract(0,true)" type="button" class="btn btn-danger" data-dismiss="modal">Reject</button>
            <button onclick="acceptAdContract(1)" type="button" class="btn btn-primary">Accept and changes</button>
        </div>
      </div>
    </div>
  </div>

  <div id="rejectNoteModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        
        <div class="modal-body p-2 text-center mt-2">
            <label for="">Reject Note</label>
            <textarea class="form-control" id="rejectNote" name="" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="modal-footer">
            <button onclick="closeModal('rejectNoteModal')" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button onclick="acceptAdContract(0)" type="button" class="btn btn-primary">Send</button>
        </div>
      </div>
    </div>
  </div>

  


@endsection



@section('scripts')
<script>
    let token = '{{\Cookie::get("jwt_token")}}';
    let route = '{{ route("apiAdDetails",":id") }}';
    let ad_id = '{{ $data->id }}';
    let payment_amount = 0;
    let addAdId = route.replace(':id',ad_id)
    let removed_influencer = null;
    $('#confirmListButton').hide();
    $('#influencer_list').hide();
    $('#fullPaymentButton').hide();

    $.ajax({
        url:addAdId,
        beforeSend: function (xhr) {
         xhr.setRequestHeader('Authorization', `${token}`);
        },
        type:'GET',
        success:(res)=>{
            let ad = res.data;
            console.log('ad data: ',ad)
            console.log('get ad response: ',ad.store_name)

            $('#budget').append(ad.format_budget)
            $('#tax_value').append(ad.tax_value)
            $('#tax_number').append(ad.cr_num)

            $('#relation').append(ad.relation.name)
            $('#goal').append(ad.campaign_goal.title)
            $('#marouf_num').append(ad.marouf_num)
            $('#about_ad').append(ad.about_product)
            $('#about_brand').append(ad.about)
            $('#from').append(ad.date)
            $('#store_link').append(`<a target="_blank" href="${ad.store_link}">click here!</a>`)
            $('#to').append(ad.end_date)
            $('#location').append(ad.country.name+','+ad.city.name+','+ad.area.name);
            $('#store').append(ad.store_name)
            $('#logo').attr('src',ad.logo.url)

            /** Handel button status **/
            if(ad.status == 'pending')
            {
                $('#customer_action_button').attr('disabled',true);
                $('#customer_action_button').append('{{ trans("messages.frontEnd.please_wait") }}');
            }
            if(ad.status == 'approve')
            {
                $('#customer_action_button').hide();
                getBluredInfluncers()
                // $('#customer_action_button').append('{{ trans("messages.frontEnd.contract_and_pay") }}');
            }
                if(ad.status == 'prepay')
            {
                $('#confirmListButton').show();
                getMatchedInfluncers();
                /*** APPEND CONFIRM BUTTON ***/

            }
            if(ad.status == "choosing_influencer" )
            {
                $('#fullPaymentButton').show();
                getConfirmedMatchedInfluncers()
            }
            if(ad.status == "fullpayment")
            {
                $('#fullPaymentButton').hide();
                getConfirmedMatchedInfluncers()
            }

            let videos = ad.videos;
            let images = ad.image;
            let media_accounts = ad.media_accounts;
          
            videos.forEach((element)=>{
                let div = `
                <div class='col'>
                    <video width="320" height="240" controls>
                    <source src="${element.url}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                </div>`;
                
                $('#videos').append(div)
           })
           images.forEach((element)=>{
               let div = `<div class='col'>
                    <img src='${element.url}' width='200px' height='150px'/>
                </div>`

                $('#images').append(div)

           });
           media_accounts.forEach((element)=>{

               let div = `<div class='col'>
                <a target="_blank" href='${element.link}'>
                    <img src='${element.image}' width='50px' height='50px'/>
                    </a>
                </div>`

                $('#social-media').append(div)
           })


        },
        error:(res)=>{
            console.log('get ad error: ',res)
        }

    })

    function getAdContract()
    {
        let route = '{{ route("getAdContract",":ad_id") }}';
        let addAdId = route.replace(':ad_id',ad_id);
        $.ajax({
            url:addAdId,
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            type:'GET',
            success:(res)=>{
                console.log('get contract response: ',res);
            },
            error:(err)=>{
                console.log('get contract error: ',err)
            }
        })
    }

    function getBluredInfluncers()
    {
        let route = '{{ route("getBlurredInfluncer",":ad_id") }}';
        let addAdId = route.replace(':ad_id',ad_id);
        $.ajax({
            url:addAdId,
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            type:'GET',
            success:(res)=>{
                $('#influencer_list').show();

                let matches = res.data.matches;
                
                let item_classification = res.data.type;
                let item_category = res.data.category;
                payment_amount = res.data.format_price;

                let calssification = `<h4 class='mt-2'>{{ trans('messages.frontEnd.type') }}: ${item_classification}</h4>`;
                let category = `<h6 class='mt-2 mb-4 text-secondary'>{{ trans('messages.frontEnd.item_classification_of_the_product') }}: ${item_category}</h6>`;
                $('#influencer_list').append(calssification);
                $('#influencer_list').append(category);


                let tabel = `
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Price</th>
                        <th scope="col">Roas</th>
                        <th scope="col">Aoaf</th>
                        <th scope="col">Engagement rate</th>
                        </tr>
                    </thead>
                    <tbody id='table_body'>
                    
                    </tbody>
                    </table>                
                `;
                $(tabel).appendTo('#influencer_list')
               

                matches.forEach((element)=>{
                    let table_content = `<tr>
                    <th scope="row"><img height='50px' width='50px'; src='https://img.freepik.com/free-vector/blurred-background-with-light-colors_1034-245.jpg?w=2000' /></th>
                    <td>**********</td>
                    <td>${element.gender}</td>
                    <td>${ element.budget }</td>
                    <td>${element.ROAS}</td>
                    <td>${element.AOAF ?? 0}</td>
                    <td>${element.engagement_rate ?? 0}</td>
                    </tr>`;
                    $('#table_body').append(table_content);
                })

                let form = `
                    <from style='display:none;' id="payment_form" method='POST' action='{{ route("check_payment") }}'>
                        <input name=''
                    </from>
                `

                let full_payment_button = `<button id="show_influncer" class="btn btn-primary mt-3 mb-3">Show influncers details</button>`;

                $('#influencer_list').append(full_payment_button);

                $('#show_influncer').click(function(){
                    let customer_alert_trans = `{{trans("messages.frontEnd.unlockInfluncerMessage",[":price"]) }}`;
                    let customer_alert  = customer_alert_trans.replace(':price',100)
                    console.log(customer_alert)
                        Swal.fire({
                            // title: '<strong>HTML <u>example</u></strong>',
                            icon: 'question',
                            html:customer_alert,
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText:'{{ trans("messages.frontEnd.next") }}',
                            cancelButtonText:'{{ trans("messages.frontEnd.cancel") }}',
                    }).then((result) => {
                        if(result.isConfirmed)
                        {
                            let get_matches = '{{ route("get_ad_influencers_match",":id") }}';
                            /** ***/
                             pay_now();
                             /**  GET MATHCH INFLUNCERS **/
                       
                        }

                    });

                });

                console.log('get blured influncers response: ',res);
            },
            error:(err)=>{
                console.log('get blured influncers error: ',err)
            }
        })

       
    }
    function pay_now()
    {
        let route = '{{ route("send_payment",":id") }}';
        let url = route.replace(':id',ad_id);

        $.ajax({
            url,
            type:'POST',
            
            data:{
                _token:'{{ csrf_token() }}',
                ad_id,
                amount:55
            },
            success:(res)=>{
                console.log('send payment: ',res)
            },
            error:(err)=>{
                console.log('erro: ',err)
            }
        });

        console.log(url);
        // $('#ad_id').val(ad_id);
        // $('#amount').val(payment_amount);
        // $('#paymentRequest').submit();

        // getMatchedInfluncers();
    }

    function getMatchedInfluncers()
    {
        let route = '{{ route("get_ad_influencers_match",":id") }}';
        let url = route.replace(':id',ad_id);
        $.ajax({
            url:url,
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            type:'GET',
            success:(res)=>{
                $('#influencer_list').show();

                let tabel = `
                    <table class="table zero-configuration table-influencers col-12">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Price</th>
                                <th>ROAS</th>
                                <th>AOAF</th>
                                <th>Engagment Rate</th>
                                <th>Is Primary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id='table_body'>
                            
                        </tbody>
                        </table>                
                    `;

            $(tabel).appendTo('#influencer_list');

                let matches = res.data.match;
                showMatchesOnModal(matches)
                console.log('full match response: ',res)

            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    function changePrmaryStatus(influncere_id,status , openModal = null)
    {
        if(openModal)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    changePrmaryStatus(influncere_id,status)
                }
            })


            return;
        }
        let url = '{{ route("changeMatchedStatus") }}';
        $.ajax({
            url,
            type:'POST',
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            data:{
                'ad_id':ad_id,
                'influncer_id':influncere_id,
                'status':status
            },
            success:(res)=>{
                let matches = res.data.match;
                $('#table_body').empty();
                matches.forEach((e)=>{
                    let table_item = `
                    <tr data-id="${e.id}">
                                        <td>
                                            <div class="thumb">
                                                <img width='50px' height='50px' class="img-fluid inf-image" src="${e.image.url}" alt="">
                                            </div>
                                        </td>
                                        <td>${e.name}</td>
                                        <td>${e.gender}</td>
                                        <td>$${e.budget}</td>
                                        <td>${e.AOAF ?? 0}</td>
                                        <td>${e.ROAS ?? 0}</td>
                                        <td>${e.engagement_rate ?? 0}%</td>
                                        <td>
                                        <button onclick='changePrmaryStatus("${e.id}","${e.is_primary?'not_basic':'basic'}")' class='btn btn-primary'>${e.is_primary?'Yes':'No'}</button>
                                        </td>
                                        <td>
                                            <button onclick='getNotChosenInfluncer("${e.id}")' class='btn btn-primary'>Replace</button>    
                                            <button onclick='changePrmaryStatus("${e.id}","deleted","deleteModal")' class='btn btn-danger'>Delete</button>
                                            <button onclick='userDetails("${e.id}")' class='btn btn-info'>Details</button>        
                                        </td>
                                    </tr>
                    ` 
                    $('#table_body').append(table_item);
                })
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                Toast.fire({
                icon: 'success',
                title: res.msg
                })

            },
            error:(err)=>{}
        })
    }

    function getNotChosenInfluncer(influncer_id)
    {
        removed_influencer = influncer_id;
        let url = '{{route("getMatchedInfluencersNotChosen",[":ad_id",":removed_inf_id"])}}';
        let add_adId = url.replace(':ad_id',ad_id);
        let add_influncerId = add_adId.replace(':removed_inf_id',influncer_id);
        $.ajax({
            url:add_influncerId,
            type:'GET',
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            success:(res)=>{
                let matches = res.data;
                $('#notChoosenInfluncersModal').modal('show');
                $('#influncer_list').empty();
                matches.forEach((e)=>{
                    let li_item = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="${e.image.url}" alt="" style="width: 45px; height: 45px"
                            class="rounded-circle" />
                            <div class="ms-3">
                            <h6 class="fw-bold mb-1">${e.name}</h6>
                            <p class="text-muted mb-0">Gender: ${e.gender}</p>
                            <p class="text-muted mb-0">Budget: $${e.budget}</p>
                            <p class="text-muted mb-0">Engagement: ${e.engagement_rate??0}</p>
                            <p class="text-muted mb-0">${e.ROAS?'Roas':'Aoaf'}: ${e.ROAS?e.ROAS:e.AOAF}</p>
                            </div>
                        </div>
                        <button onclick='replaceInfluncer("${e.id}")' class="btn btn-primary" ${!e.eligible?'disabled':''} >Replace</button>
                    </li>
                `
                    $('#influncer_list').append(li_item);
                })

               
                console.log('replace influncers: ',matches)
            },
            error:(err)=>{}
        })
    }

    function replaceInfluncer(chosen_influencer)
    {
        let url = '{{route("replaceMatchedInfluencer",[":ad_id",":removed_influencer",":chosen_influencer"])}}';
        let add_adId = url.replace(':ad_id',ad_id);
        let add_removeInfluncer = add_adId.replace(':removed_influencer',removed_influencer);

        let add_chosen_influencer = add_removeInfluncer.replace(':chosen_influencer',chosen_influencer);

        $.ajax({
            url:add_chosen_influencer,
            type:'GET',
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            success:(res)=>{

                let matches = res.data.match;
                showMatchesOnModal(matches);
                $('#notChoosenInfluncersModal').modal('hide');

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                Toast.fire({
                icon: 'success',
                title: res.msg
                })


            },
            error:(err)=>{

            }
        })


    }
    function closeModal(modal_name)
    {
            $('#'+modal_name).modal('hide');
    }

    function showMatchesOnModal(matches)
    {
                $('#table_body').empty();
                matches.forEach((e)=>{
                    let table_item = `
                    <tr data-id="${e.id}">
                                        <td>
                                            <div class="thumb">
                                                <img width='50px' height='50px' class="img-fluid inf-image" src="${e.image.url}" alt="">
                                            </div>
                                        </td>
                                        <td>${e.name}</td>
                                        <td>${e.gender}</td>
                                        <td>$${e.budget}</td>
                                        <td>${e.AOAF ?? 0}</td>
                                        <td>${e.ROAS ?? 0}</td>
                                        <td>${e.engagement_rate ?? 0}%</td>
                                        <td>
                                        <button onclick='changePrmaryStatus("${e.id}","${e.is_primary?'not_basic':'basic'}")' class='btn btn-primary'>${e.is_primary?'Yes':'No'}</button>
                                        </td>
                                        <td>
                                            <button onclick='getNotChosenInfluncer("${e.id}")' class='btn btn-primary'>Replace</button>    
                                            <button onclick='changePrmaryStatus("${e.id}","deleted","deleteModal")' class='btn btn-danger'>Delete</button>    
                                            <button onclick='userDetails("${e.id}")' class='btn btn-info'>Details</button>    
                                        </td>
                                    </tr>
                    ` 
                    $('#table_body').append(table_item);
        });
    }

    function userDetails(influncer_id)
    {
        let url = '{{ route("usersDetails",[":id","influencer"]) }}';
        let add_influncerId = url.replace(':id',influncer_id);
        $.ajax({
            url:add_influncerId,
            type:'GET',
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            success:(res)=>{
                console.log('response: ',res);
                let user_details = res.data;
                let icons = ['facebook-f','twitter','snapchat'];

                /**  APPEND USER DATA **/
                $('#avatar').empty()
                $('#avatar').attr('src',user_details.image.url);
                $('#user_name').empty()
                $('#user_name').append(user_details.nick_name);
                $('#user_location').empty()
                $('#user_location').append(user_details.region+','+user_details.city+','+user_details.country);
                /**  Append categories **/
                $('#social_media').empty();
                
                user_details.social_media_profile.forEach((e)=>{
                    let item = `<a target='_blank' href="${e.link}" type="button" class="btn btn-outline-primary btn-floating"><i class="fab fa-${icons[e.id]}"></i></a>`;
                    $('#social_media').append(item);
                })

                $('#bio').empty()
                $('#bio').append(user_details.bio);
                $('#categories_modal').empty();

                user_details.influencer_category_names.forEach((e)=>{
                    let item = ` <div class="col-md-3 mb-2"><button type="button" class="btn btn-info"> <span class="badge">${e}</span></button></div>`;
                    $('#categories_modal').append(item);
                });

                $('#media_modal').empty()
                user_details.gallery.forEach((e)=>{
                    let media = `<div class="col-md-3 mb-2"><a href='${e.url}'><img width="100" height="150px" src="${e.video_thumb}" /></a></div>`
                    $('#media_modal').append(media);
                });
                if(user_details.gallery.length == 0)
                {
                    $('.media_details').hide();
                }



                $('#userDetails').modal('show');
            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    function confirmList()
    {
        Swal.fire({
                title: 'Are you sure?',
                text: "You Want to confirm chooses",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    /** SEND API REQUEST **/
                    let route = '{{ route("confirmInfluncerList",":id") }}';
                    let url = route.replace(':id',ad_id);
                    $.ajax({
                        url,
                        type:'POST',
                        data:{},
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', `${token}`);
                        },
                        success:(res)=>{
                            console.log('response: ',res);
                            if(res.status == 200)
                            {
                                $('#confirmListButton').hide();
                            }
                        },
                        error:(err)=>{
                            console.log('error: ',err);
                        }
                    });
                    

                }
            })
    }

    function getConfirmedMatchedInfluncers()
    {
        let route = '{{ route("get_ad_influencers_match",":id") }}';
        let url = route.replace(':id',ad_id);
        $.ajax({
            url:url,
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            type:'GET',
            success:(res)=>{
                $('#influencer_list').show();

                let tabel = `
                    <table class="table zero-configuration table-influencers col-12">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Price</th>
                                <th>ROAS</th>
                                <th>AOAF</th>
                                <th>Engagment Rate</th>
                            </tr>
                        </thead>
                        <tbody id='table_body'>
                            
                        </tbody>
                        </table>                
                    `;

            $(tabel).appendTo('#influencer_list');

                let matches = res.data.match;
                if(res.influncers_status)
                {
                    
                }
                showConfirmedMatchesOnModal(matches)
                console.log('full match response: ',res)

            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    function showConfirmedMatchesOnModal(matches)
    {
                $('#table_body').empty();
                matches.forEach((e)=>{
                    let table_item = `
                    <tr data-id="${e.id}">
                                        <td>
                                            <div class="thumb">
                                                <img width='50px' height='50px' class="img-fluid inf-image" src="${e.image.url}" alt="">
                                            </div>
                                        </td>
                                        <td>${e.name}</td>
                                        <td>${e.gender}</td>
                                        <td>$${e.budget}</td>
                                        <td>${e.AOAF ?? 0}</td>
                                        <td>${e.ROAS ?? 0}</td>
                                        <td>${e.engagement_rate ?? 0}%</td>
                                    </tr>
                    ` 
                    $('#table_body').append(table_item);
        });
    }

    function getCustomerContract()
    {
        let route = '{{ route("contractApi",":id") }}';
        let addIdToUrl = route.replace(":id",ad_id)
        $('#contractData').modal('show');
        // $('#pdf_file').attr('src','http://www.africau.edu/images/default/sample.pdf');
        // $.ajax({
        //     url:addIdToUrl,
        //     type:'GET',
        //     beforeSend:function (xhr) {
        //         xhr.setRequestHeader('Authorization', `${token}`);
        //     },
        //     success:(res)=>{},
        //     error:(err)=>{}
        // });
    }

    function acceptAdContract(status,openModal)
    {
        if(openModal)$('#rejectNoteModal').modal('show');
        let route = '{{ route("acceptAdContract",":ad_id") }}';
        let url = route.replace(':ad_id',ad_id);
        $.ajax({
            url,
            type:'POST',
            beforeSend:function (xhr) {
                xhr.setRequestHeader('Authorization', `${token}`);
            },
            data:{
                status,
                rejectNote:document.getElementById('rejectNote').value
            },
            success:(res)=>{
                $('#fullPaymentButton').hide();
                $('#rejectNoteModal').modal('hide');
                $('#contractData').modal('hide');
                window.location.reload();
            },
            error:(err)=>{
                console.log('error: ',err)
            }
            
        })
    }

</script>
@endsection