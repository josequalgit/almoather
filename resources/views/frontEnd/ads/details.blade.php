@extends('frontEnd.layouts.index')

@section('content')
<style>

 .title {
    font-weight: bolder;
    font-size: 18px;
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
               
                    
    

        </div>
    </div>
        </section>
@endsection



@section('scripts')
<script>
    let token = '{{\Cookie::get("jwt_token")}}';
    let route = '{{ route("apiAdDetails",":id") }}';
    let ad_id = '{{ $data->id }}';
    let payment_amount = 0;
    let addAdId = route.replace(':id',ad_id)
    $('#influencer_list').hide();
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
                getMatchedInfluncers();
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
        $('#ad_id').val(ad_id);
        $('#amount').val(payment_amount);
        // $('#paymentRequest').submit();

        getMatchedInfluncers();
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
                                        <button class='btn btn-primary'>Replace</button>    
                                        <button onclick='changePrmaryStatus("${e.id}","deleted")' class='btn btn-danger'>Delete</button>    
                                    </td>
                                </tr>
            ` 
                $('#table_body').append(table_item);
                })

          
            

                console.log('full match response: ',res)
            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    function changePrmaryStatus(influncere_id,status)
    {
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
                                            <button class='btn btn-primary'>Replace</button>    
                                            <button class='btn btn-danger'>Delete</button>    
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
</script>
@endsection