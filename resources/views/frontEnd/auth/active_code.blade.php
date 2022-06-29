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
       .form-control2 {
    display: block;
    height: 50px;
    margin-right: 0.5rem;
    text-align: center;
    font-size: 1.25rem;
    min-width: 0;
    
    &:last-child {
      margin-right: 0;
    }
  }
  </style>
  <body class="body">
    <!-- menu section -->
   
      <!-- end menu section -->
      <section class="background-page5 min-height-100 position-relative d-flex align-items-center">
        <div class="container">
           <div class="login text-center p-5">
               <div class="container">
                   <div class="row">
                       <div class="col-md-6 col-12 login2">
                           <div class="left-side">
                               <div class="col-12">
                                   <div >
                                    <img src="{{ asset('frontEnd/img/Rectangle_16251-r.png') }}"  alt="">
                                </div>
                               </div>
                               <div class="col-8 mt-3">
                                   <div class="text-left-side">
                                    <h3>{{ $data->title->{app()->getlocale()} }}</h3>
                                    <p>{{ $data->description->{app()->getlocale()} }} </p>
                                   </div>
                                   </div>
                           </div>
                       </div>
                       <img class="arrow-img2" src="{{ asset('frontEnd/img/Group 50667.png') }}" alt="">
                       <div class="col-md-6 col-12 text-center">
                           <div>
                               <div class="title">
                                   <div class="icon">
                                       <img src="{{ asset('frontEnd/img/logo.png') }}" width="150px" height="150px" alt="">
                                   </div>
                                   <h3>Almuather</h3>

                               </div>
                               <form method="POST" action="{{ route('activateCode') }}">
                                <h4 class="text-center mb-4">Enter your code</h4>
                              
                                <div class="d-flex mb-3">
                                  <input id="code_1" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                  <input id="code_2" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                  <input id="code_3" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                  <input id="code_4" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                  <input id="code_3" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                  <input id="code_4" type="tel" max="1" pattern="[0-9]" class="form-control2">
                                </div>
                                <button onclick="activeCode()" type="button" class="btn btn-none login-button p-0" id="register">Activate</button>
                              </form>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
      
    </section>
  
 
      <!-- Footer -->
     
      <!-- End Footer -->
     <!--JAVASCRIPT-->
     <script type='text/javascript' src='{{ asset('frontEnd/js/jquery-3.6.0.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/bootstrap.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/all.min.js') }}'></script>
     <script type='text/javascript' src='{{ asset('frontEnd/js/main.js') }}'></script>
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <!--End JAVASCRIPT-->
     <script>
         const form = document.querySelector('form')
const inputs = form.querySelectorAll('input')
const KEYBOARDS = {
  backspace: 8,
  arrowLeft: 37,
  arrowRight: 39,
}

function handleInput(e) {
  const input = e.target
  const nextInput = input.nextElementSibling
  if (nextInput && input.value) {
    nextInput.focus()
    if (nextInput.value) {
      nextInput.select()
    }
  }
}

function handlePaste(e) {
  e.preventDefault()
  const paste = e.clipboardData.getData('text')
  inputs.forEach((input, i) => {
    input.value = paste[i] || ''
  })
}

function handleBackspace(e) { 
  const input = e.target
  if (input.value) {
    input.value = ''
    return
  }
  input.previousElementSibling.focus()
}

function handleArrowLeft(e) {
  const previousInput = e.target.previousElementSibling
  if (!previousInput) return
  previousInput.focus()
}

function handleArrowRight(e) {
  const nextInput = e.target.nextElementSibling
  if (!nextInput) return
  nextInput.focus()
}

function activeCode()
{
    let code = document.getElementById('code_1').value+document.getElementById('code_2').value+document.getElementById('code_3').value+document.getElementById('code_4').value;
    let url = '{{ route("activateCodeWeb") }}';
    $.ajax({
        url:url,
        type:'POST',
        data:{
            code,
        },
        success:(res)=>{
            console.log('success: ',res);
            window.location.href = '{{ route("influencers.index") }}'
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
    })
}

form.addEventListener('input', handleInput)
inputs[0].addEventListener('paste', handlePaste)

inputs.forEach(input => {
  input.addEventListener('focus', e => {
    setTimeout(() => {
      e.target.select()
    }, 0)
  })
  
  input.addEventListener('keydown', e => {
    switch(e.keyCode) {
      case KEYBOARDS.backspace:
        handleBackspace(e)
        break
      case KEYBOARDS.arrowLeft:
        handleArrowLeft(e)
        break
      case KEYBOARDS.arrowRight:
        handleArrowRight(e)
        break
      default:  
    }
  })
})



     </script>
 </body>
</html>
