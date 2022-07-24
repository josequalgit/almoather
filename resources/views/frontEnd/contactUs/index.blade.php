@extends('frontEnd.layouts.index')

@section('content')
<section class="section contact_section" style="background-image: url('{{asset('frontEnd/img/page2-section.png')}}')">
    <div class="right-img-page2">
      <img  src="{{ asset('frontEnd/img/Group50.png') }}" width="200px" height="200px" alt="">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
          <h1>{{ $contact_us->title }}</h1>
          <p> {{ $contact_us->description }} </p>
        </div>
      </div>
    </div>
      <div class="container pb-4">
        
        <div class="row space-row-page ">
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div>
              <div class="contact-form-wrapper d-flex justify-content-start">
                <form action="#" class="contact-form">
                  <h5 class="title">{{ trans('messages.frontEnd.send_us_a_message') }} </h5>
                  </p>
                  <div>
                    <input type="text" class="form-control rounded border-white mb-3 form-input" id="name" placeholder="{{ trans('messages.frontEnd.name') }}">
                  </div>
                  <div>
                    <input id="email" type="email" class="form-control rounded border-white mb-3 form-input" placeholder="{{ trans('messages.frontEnd.email') }}">
                  </div>
                  <div>
                    <textarea id="message" class="form-control rounded border-white mb-3 form-text-area" rows="5" cols="30" placeholder="{{ trans('messages.frontEnd.message') }}"></textarea>
                  </div>
                  <div class="submit-button-wrapper">
                    <button onclick="addContactMessage()" class="btn btn-none" type="button"><i class="fa-solid fa-paper-plane"></i> {{ trans('messages.frontEnd.send') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="person col-lg-6 col-md-12 col-sm-12 position-relative">
            <img class="position-absolute" src="{{ asset('frontEnd/img/person.png') }}" alt="">
          </div>
        </div>
       
      </div>
   
</section>


    <!-- End Contact us -->
      <!-- Map -->
      @if($location)
      <section class="map">
        <iframe src="{{ $location->link }}" width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </section>
      @endif
      <!-- End Map -->

      <section class="map position-relative">
        <div class="left-phone">
          <img  src="{{ asset('frontEnd/img/Icon awesome-phone-square-alt.png') }}" width="200px" height="200px" alt="">
        </div>
        <div class="left-dotted">
          <img  src="{{ asset('frontEnd/img/Group 50196.png') }}" width="300px" height="300px" alt="">
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
              <h1> {{ $get_in_touch?->title->{app()->getLocale()} }} </h1>
              <p> {{ $get_in_touch?->description->{app()->getLocale()} }} </p>
            </div>
          </div>
          <div class="row space-row-page mt-5">
              <div class="col-lg-4 col-md-12 col-sm-12 mt-md-5" >
                <div class="contact-form-wrapper p-2 ">
                  <div  class="contact-form1 text-left">
                    <h5 class="title" id="title-button">{{ trans('messages.frontEnd.phone') }}</h5>
                    </p>
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-solid fa-phone fa-lg px-3" style="color:#CA9B3D ;"></i>{{ $contact_info->phone }}</button>
                    </div >
                    
                   
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-12 col-sm-12">
                <div  class="contact-form-wrapper center-top-div p-2">
                  <div   id="contact-form1-center" class="contact-form1 text-left">
                    <h5 class="title" id="title-button2">{{ trans('messages.frontEnd.email') }}</h5>
                    </p>
                    <div>
                      <button  class="center-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-solid fa-envelope fa-lg px-3" style="color:#CA9B3D ;"></i>{{ $contact_info->email }}</button>
                    </div>
                   
                    <div id="height-div">
                    </div>
                  </div>
                </div>
              </div>
             
              <div class="col-lg-4 col-md-12 col-sm-12 mt-md-5">
                <div class="right-mail">
                  <img  src="{{ asset('frontEnd/img/Icon ionic-ios-mail.png') }}" width="150px" height="150px" alt="">
                </div>
                <div class="right-dotted-social">
                  <img  src="{{ asset('frontEnd/img/Group2.png') }}" width="300px" height="300px" alt="">
                </div>
                <div  class="contact-form-wrapper p-2 position-relative">
                  <div  class="contact-form1 text-left">
                    <h5 class="title" id="title-button">{{ trans('messages.frontEnd.social_media') }}</h5>
                    </p>
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-facebook fa-lg px-3" style="color:#CA9B3D ;"></i>{{ trans('messages.frontEnd.social_media',['name'=>'فيسبوك']) }}</button>
                    </div >
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-youtube fa-lg px-3" style="color:#CA9B3D ;"></i>{{ trans('messages.frontEnd.social_media',['name'=>'انستغرام']) }}</button>
                    </div>
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-twitter fa-lg px-3" style="color:#CA9B3D ;"></i>{{ trans('messages.frontEnd.social_media',['name'=>'تويتر']) }}</button>
                    </div>
                   
                  </div>
                  
                </div>
              </div>
          </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 7000,
            timerProgressBar: true,
           
        })

    function addContactMessage()
    {
        if(!contactMessageValdation())return;
        let route = '{{ route("contact.store_contact_messages") }}';
        $.ajax({
            url:route,
            type:'POST',
            data:{
                _token:'{{ csrf_token() }}',
                name:document.getElementById('name').value,
                email:document.getElementById('email').value,
                message:document.getElementById('message').value,
            },
            success:()=>{
                Toast.fire({
                icon: 'success',
                title: 'Success',
                text: 'Message was sent',
            })
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('message').value = '';
            },
            error:()=>{}
        })
    }

    function contactMessageValdation()
    {
        var emailValdation = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
        console.log(emailValdation.test(document.getElementById('email').value))

        if(document.getElementById('name').value == '')
        {
            Toast.fire({
                icon: 'error',
                title: 'Valdation Error',
                text: 'Please add your name',
            })
            return false;
        }
        if(document.getElementById('email').value == '')
        {
            Toast.fire({
                icon: 'error',
                title: 'Valdation Error',
                text: 'Please add your email',
            })
            return false;
        }
        if(!emailValdation.test(document.getElementById('email').value))
        {
            Toast.fire({
                icon: 'error',
                title: 'Valdation Error',
                text: 'Please add correct email',
            })
            return false;
        }
        if(document.getElementById('message').value == '')
        {
            Toast.fire({
                icon: 'error',
                title: 'Valdation Error',
                text: 'Please add the message',
            })
            return false;
        }
        return true;
    }
</script>
@endsection