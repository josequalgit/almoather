@extends('frontEnd.layouts.index')

@section('content')
<section class="section section2">
    <div class="right-img-page2">
      <img  src="{{ asset('FrontEnd/img/Group50.png') }}" width="200px" height="200px" alt="">
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
                  <h5 class="title">Send us a message </h5>
                  </p>
                  <div>
                    <input type="text" class="form-control rounded border-white mb-3 form-input" id="name" placeholder="Name">
                  </div>
                  <div>
                    <input id="email" type="email" class="form-control rounded border-white mb-3 form-input" placeholder="Email">
                  </div>
                  <div>
                    <textarea id="message" class="form-control rounded border-white mb-3 form-text-area" rows="5" cols="30" placeholder="Message"></textarea>
                  </div>
                  <div class="submit-button-wrapper">
                    <button onclick="addContactMessage()" class="btn btn-none" type="button"><i class="fa-solid fa-paper-plane"></i> Send</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="person col-lg-6 col-md-12 col-sm-12 position-relative">
            <img class="position-absolute" src="{{ asset('FrontEnd/img/person.png') }}" alt="">
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
          <img  src="{{ asset('FrontEnd/img/Icon awesome-phone-square-alt.png') }}" width="200px" height="200px" alt="">
        </div>
        <div class="left-dotted">
          <img  src="{{ asset('FrontEnd/img/Group 50196.png') }}" width="300px" height="300px" alt="">
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
                    <h5 class="title" id="title-button">Phone </h5>
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
                    <h5 class="title" id="title-button2">Email</h5>
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
                  <img  src="{{ asset('FrontEnd/img/Icon ionic-ios-mail.png') }}" width="150px" height="150px" alt="">
                </div>
                <div class="right-dotted-social">
                  <img  src="{{ asset('FrontEnd/img/Group2.png') }}" width="300px" height="300px" alt="">
                </div>
                <div  class="contact-form-wrapper p-2 position-relative">
                  <div  class="contact-form1 text-left">
                    <h5 class="title" id="title-button">Social Media</h5>
                    </p>
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-facebook fa-lg px-3" style="color:#CA9B3D ;"></i>Like our facebook page</button>
                    </div >
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-youtube fa-lg px-3" style="color:#CA9B3D ;"></i>Like our instagram page</button>
                    </div>
                    <div>
                      <button  class="left-form form-control btn btn-none rounded border-white mb-3 " ><i class="fa-brands fa-twitter fa-lg px-3" style="color:#CA9B3D ;"></i>Get our twitter updates</button>
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