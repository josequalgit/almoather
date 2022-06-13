@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
<div class="content-wrapper">
    <section id="basic-input">
        @can('Edit Contact Us')
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.contactUs.update') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <p class="mb-0">Update Contact Us</p>
                        </div>
                    </div>
                    
                    <hr class="w-100 my-1">
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert"> There is something wrong
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Name</label>
                                  <input value="{{ old('name')?old('name'):$data->name }}" name="name" type="text" class="form-control" id="inputEmail4" placeholder="Enter Name">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">Title</label>
                                  <input value="{{ old('title')?old('title'):$data->title }}" name="title" type="text" class="form-control" id="inputPassword4" placeholder="Enter Title">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputAddress">Email</label>
                                <input value="{{ old('email')?old('email'):$data->email }}" name="email" type="email" class="form-control" id="inputAddress" placeholder="Enter Email">
                              </div>
                              <div class="form-group">
                                <label for="inputAddress2">Message</label>
                                <textarea class="form-control" name="message">{{ old('message')?old('message'):$data->message }}</textarea>
                              </div>
                             
                              <hr/>
                              <button type="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                       
                    </div>
            </div>
        </div>
        </form>
        @endcan
        @can('Edit Terms')
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.terms.update') }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Update Terms</p>
                            </div>
                        </div>
                        <hr class="w-100 my-1">

                        
                        
                        <div class="card-body">
                                <div class="">
                                    <div class="form-group col">
                                    <label for="inputEmail4">Text EN</label>
                                    <textarea name="text_en" class="form-control" id="exampleFormControlTextarea1" rows="10">{{ old('text')?old('text'):$terms->getTranslations('text')['en'] }}</textarea>
                                    </div>
                                    <div class="form-group col">
                                    <label for="inputEmail4">Text AR</label>
                                    <textarea name="text_ar" class="form-control" id="exampleFormControlTextarea1" rows="10">{{ old('text')?old('text'):$terms->getTranslations('text')['ar'] }}</textarea>
                                    </div>
                                
                                
                                <hr/>
                                <button type="submit" class="btn btn-primary float-right ">Update</button>
                            </div>
                        
                        </div>
                </div>
            </div>
            </form>
                
        @endcan
        
        @can('Edit Privacy')
            <form  class="col" method="post" enctype="multipart/form-data" action="{{ route('dashboard.privacy.update') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="card">
                            
                            <div class="card-header">
                                <div class="card-title">
                                    <p class="mb-0">Update Privacy</p>
                                </div>
                            </div>
                            <hr class="w-100 my-1">
                            <div class="card-body">
                                    <div class="">
                                        <div class="form-group col">
                                        <label for="inputEmail4">Text EN</label>
                                        <textarea name="text_en" class="form-control" id="exampleFormControlTextarea1" rows="10">{{ old('text_en')?old('text_en'):$privacy->getTranslations('text')['en'] }}</textarea>
                                        </div>
                                    
                                        <div class="form-group col">
                                        <label for="inputEmail4">Text AR</label>
                                        <textarea name="text_ar" class="form-control" id="exampleFormControlTextarea1" rows="10">{{ old('text_ar')?old('text_ar'):$privacy->getTranslations('text')['ar'] }}</textarea>
                                        </div>
                                    
                                    
                                    <hr/>
                                    <button type="submit" class="btn btn-primary float-right ">Update</button>
                                </div>
                            
                            </div>
                    </div>
                </div>
            </form>
        @endcan
    
    </section>

</div>


      
</div>

@endsection