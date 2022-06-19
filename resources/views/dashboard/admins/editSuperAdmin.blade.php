@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
        <div class="content-wrapper">
            <div class="emp-profile">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert"> There is something wrong
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form id="admin_form" method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.updateSuperAdmin') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="profile-img">
                                <img id="preview" src="{{ auth()->user()->adminImage['url']}}" alt=""/>
                                <div class="file btn btn-lg btn-primary">
                                    Change Photo
                                    <input id="photo" type="file" name="image"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-head">
                                        <h5>
                                            Super Admin Edit
                                        </h5>
                                        <hr>
                                  
                                            @csrf
                                            <div class="border p-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Name</label>
                                                    <input name="name" value="{{ old('name') ? old('name') : $data->name }}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="emailInput">Email</label>
                                                    <input name="email" value="{{ old('email') ? old('email') : $data->email }}" type="email" class="form-control" id="emailInput" placeholder="Email">
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input name="password" value="" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Confirm Password</label>
                                                    <input name="con_password" value="" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password re-type the password">
                                                  </div>
                                                 <div class="text-center">

                                                     <button id="admin_form_button" type="submit" class="profile-edit-btn text-center">Update</button>
                                                 </div>
                                            </div>
                                    </div>
                                </div>
                              
                       
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="profile-work">

                            </div>
                        </div>
                      
                    </div>
            </div>
        </div>
    </form>

    </div>
    
@endsection
@section('scripts')
    <script>
        var src = document.getElementById("photo");
        var target = document.getElementById("preview");
        var extensionLists = ['jpg', 'gif', 'bmp', 'png','jpeg'];
        let adminCurrentImage = '{{ auth()->user()->adminImage["url"] }}';
        showImage(src,target);

        function showImage(src,target) {
            var fr=new FileReader();

            fr.onload = function(e) { target.src = this.result; };
            src.addEventListener("change",function() {
                
                let getExtension = src.files[0].type.split("/")[1];
                console.log(getExtension)
               if(!extensionLists.includes(getExtension))
               {
                
                document.getElementById("preview").src = adminCurrentImage;
                document.getElementById("photo").value = '';
                
                Toast.fire({
                    icon: 'error',
                    title: 'Error Getting the image',
                    text:'Please add image of these types: '+extensionLists.join('/')
                })
                    return;
               }
                fr.readAsDataURL(src.files[0]);
            });
        }


    </script>
@endsection
