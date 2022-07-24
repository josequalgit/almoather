@extends('frontEnd.layouts.index')
@section('content')
<style>
    .btn-primary {
    color: #fff;
    background-color: #8e8ab0;
    border-color: #8c88ae;
    }
    .btn-primary:hover {
        color: #fff;
        background-color: #ca9b3d;
        border-color: #ca9b3d;
    }
    .btn-primary:active {
        color: #fff;
        background-color: #ca9b3d;
        border-color: #ca9b3d;
    }
</style>

 <section  class="section-contract" style="background-image: url('{{ asset('frontEnd/img/Rectangle%2016355.png') }}')">
    <div class="min-height-100">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-lg-12 col-md-12 col-sm-12   mt-5 ">
                <ul class="nav nav-pills  justify-content-between text-center" id="pills-tab" role="tablist" >
                    <li class="nav-item content-button col-md-3 col-6 " role="presentation ">
                        <button onclick="getAds('Active')" class="nav-link btn btn-none" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ trans('messages.frontEnd.new_requests') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button onclick="getAds('Pending')" class="nav-link btn btn-none active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ trans('messages.frontEnd.approved') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation ">
                        <button onclick="getAds('Rejected')" class="nav-link btn btn-none" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.rejected') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button onclick="getAds('Completed')" class="nav-link btn btn-none" id="pills-Canceled-tab" data-bs-toggle="pill" data-bs-target="#pills-Canceled" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.completed') }}</button>
                    </li>
                  </ul>
                  <div class="container">
                    <div class="tab-content " id="pills-tabContent">
                        <div class="tab-pane ul-content fade  w-40" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                           
                              <div id="ad_content_Active" class="row text-center mt-3 ads-container">
                                New Requests
                              </div>
                           
                        </div>
                        <div  class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                            <div id="ad_content_Pending" class="row text-center mt-3 ads-container">
                                Approved
                            </div>  

                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">


                            <div id="ad_content_Rejected" class="row text-center mt-3 ads-container">
                                Rejected
                            </div>

                        </div>
                        <div  class="tab-pane fade" id="pills-Canceled" role="tabpanel" aria-labelledby="pills-Canceled-tab">


                            <div id="ad_content_Completed" class="row text-center mt-3 ads-container">
                                Completed
                            </div>

                        </div>
                           <div class="mt-3 col text-center">
                                <button onclick="getNextPage()" id="loadMoreData" class="btn btn-primary w-50 load-more-button">
                                    {{ trans('messages.frontEnd.more') }}
                                </button>
                              </div>
                      </div>
                  </div>
                  
             </div>
          </div>
       
        </div>
      </div>
  
  </section>
@endsection
@php
$token = Cookie::get('jwt_token');
@endphp

@section('scripts')
<script>
    let current_page = 0;
    let last_page = 0;
    let current_status = '';
    let page_number = 1;
    let jwt_token = '{{ $token }}';

    getAds('Pending');
    $('#loadMoreData').hide();
   
    /** FOR GETTING ADS **/
    function getAds(status)
    {
        current_status = status;

        let route = '{{ route("getAdsApi",":status") }}';
        let add_status = route.replace(':status',status);
        console.log(add_status)
        let token = $('meta[name="csrf-token"]').attr('content');

        /** Delete the old data **/
        $('#loadMoreData').hide();
        $('#ad_content_Active').empty();
        $('#ad_content_Pending').empty();
        $('#ad_content_Rejected').empty();
        $('#ad_content_Finished').empty();


        $.ajax({
            url:add_status,
            beforeSend: function (xhr) {
                 xhr.setRequestHeader('Authorization', `${jwt_token}`);
            },
            type:'GET',
            success:(res)=>{
             let data_array = res.data.data;
             current_page = res.data.current_page;
             last_page = res.data.last_page;
              
              if(data_array.length >= res.data.per_page&&res.data.per_page != 0)  $('#loadMoreData').show();
              else  $('#loadMoreData').hide();

             adsResponse(data_array);
            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    /** Pagination function **/
    function getNextPage()
    {
        let route = '{{ route("getAdsApi",":status") }}';
        let add_status = route.replace(':status',current_status);
        let next_page = current_page+1;
        $.ajax({
            url:add_status+'?page='+next_page,
            type:'GET',
            dataType: 'json', 
            beforeSend: function (xhr) {
                 xhr.setRequestHeader('Authorization', `${jwt_token}`);
            },
            success:(res)=>{
             console.log('response: ',res)
             current_page = res.data.current_page;
             last_page = res.data.last_page;
             if(res.data.current_page == res.data.last_page) $('#loadMoreData').hide();
             let data_array = res.data.data;
             adsResponse(data_array);
            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    function adsResponse(data_array)
    {
        console.log(data_array);
        let div = '';
        for (let index = 0; index < data_array.length; index++) {
                 var element = data_array[index];
                 console.log(element);
                 let route = "{{ route('influencers.ads.details',':id') }}";
                 let addIdToRoute = route.replace(':id',element.id);
                   div += `<div class="col-sm-4 mt-2">
                  
                                       <div class="card background-box-content">
                                        <div class='text-end'>
                                                <p>#${element.id}</p>
                                            </div>
                                         <div class="card-body">
                                            
                                             <div class="row">
                                                 <div class="col text-end">
                                                     <img src="${element.logo.url}">
                                                 </div>
                                                 <div class="col text-start above-text">
                                                     <p >${element.store_name}</p>  
                                                     <span>${element.product_type ?? ''}</span>  
                                                 </div>
                                                 <hr class="mt-2 hr-content" width="80px">
                                             </div>
                                                <div class='col text-center' width="80px">
                                                    <label>{{ trans('messages.frontEnd.date') }}:${element.start_date}</label>
                                                </div>
                                         
                                                <div class='col text-center' width="80px">
                                                    <label>{{ trans('messages.frontEnd.type') }}:${element.is_onSite}</label>
                                                </div>
                                         
                                                <div class='col text-center mb-2' width="80px">
                                                    <label>{{ trans('messages.frontEnd.location') }}:${element.location}</label>
                                                </div>

                                         <div class='text-center'>
                                                <a href="${addIdToRoute}" class="btn btn-primary w-75">{{ trans('messages.frontEnd.details') }}</a>    
                                            </div>
                                       </div>
                                     </div>`;
                                     

                
                 
             }
             $("#ad_content_"+current_status).html(div)
    }
</script>
@endsection