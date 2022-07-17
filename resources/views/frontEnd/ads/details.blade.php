@extends('frontEnd.layouts.index')

@section('content')
<style>

 .title {
    font-weight: bolder;
    font-size: 18px;
}
</style>
<section  class="section-contract" style="background-image: url('{{ asset('frontEnd/img/Rectangle%2016355.png') }}')">
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
                                    <label for="exampleInputEmail1">Number of tax: <span id="tax_value"></span></label>
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

    let addAdId = route.replace(':id',ad_id)
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
            $('#about_ad').append(ad.about_product)
            $('#about_brand').append(ad.about)
            $('#goal').append(ad.campaign_goal.title)
            $('#from').append(ad.date)
            $('#to').append(ad.end_date)
            $('#goal').append(ad.campaign_goal.title)
            $('#location').append(ad.country.name+','+ad.city.name+','+ad.area.name);
            $('#store').append(ad.store_name)
            $('#logo').attr('src',ad.logo.url)
            let videos = ad.videos;
            let images = ad.image;
          
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

           })
        },
        error:(res)=>{
            console.log('get ad error: ',res)
        }

    })
</script>
@endsection