@extends('dashboard.layout.index')
@section('content')
<div class="app-content content p-5 mt-5">
    
    <section id="basic-input">
        <div class="card p-5">
            @if($errors->any())
            <div class="alert alert-danger" role="alert"> There is something wrong
                @foreach ($errors->all() as $error )
                    <li>{{$error}}</li>
                @endforeach
            </div>
            @endif
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.updateSuperAdmin') }}">
           @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input value="{{ old('email')?old('email'):$data->email }}" name="email" type="email" class="form-control" id="inputEmail4" placeholder="Email">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input  name="password" type="password" class="form-control" id="inputPassword4" placeholder="Password">
              </div>
            </div>
         
            <div class="form-group">
              <label for="inputAddress2">Name</label>
              <input value="{{ old('name')?old('name'):$data->name }}" name="name" type="text" class="form-control" id="inputAddress2" placeholder="Add the admin name">
            </div>
           

            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>

   
        </section>

      
</div>

@endsection