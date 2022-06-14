@extends('dashboard.layout.index')
@section('content')
<style>
    .emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
    
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -11%;
    margin-left: 11%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
    width: 78%;

}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
#preview{
    width: 300px;
    height: 300px;
    object-fit: contain;
}
</style>
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
