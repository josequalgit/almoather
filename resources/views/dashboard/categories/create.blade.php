@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
    
    <section id="basic-input" class="content-wrapper">
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.categories.store') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="mb-0">Create Category</p>   
                        </div>
                        <hr class="w-100 mt-1">
                    </div>
                        
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert"> There is something wrong
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                    
                        <div class="row">
                            <div class="col-12">
                              
                                {{-- <fieldset class="form-group d-flex justify-content-center">
                                    
                                    <div class="imgUp col-lg-4 col-md-7 col-12">
                                        <div class="imagePreview"></div>
                                    <label class="btn btn-primary">
                                            Upload<input name="image" type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                                    </label>
                                      </div><!-- col-2 -->
                                    
                                </fieldset> --}}
                                <fieldset class="form-group">
                                    <label for="basicInput">Name EN</label>
                                    <input id="name" value="{{ old('name_en') }}" type="text" class="form-control"  name="name_en" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name AR</label>
                                    <input id="name" value="{{ old('name_ar') }}" type="text" class="form-control"  name="name_ar" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Type</label>
                                    <div class="form-group">
                                        <select  name='type' class="form-control" id="exampleFormControlSelect1">
                                          <option value="service">Service</option>
                                          <option value="product">Product</option>
                                        </select>
                                      </div>
                                </fieldset>
                               
                                <fieldset class="form-group">
                                    <label for="basicInput">Exclude Category</label>
                                    <div class="form-group">
                                        <select  multiple name='exclude_categories[]' class="form-control exclude_categories" id="exclude_categories">
                                            @foreach ($categories as $item)
                                            <option  value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                      </div>
                                </fieldset>
    
                               
    
                            </div>
                        
                        </div>
                        <hr/>
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </section>

      
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
    $('.categories').select2();
    $('.preferred_categories').select2();
    $('.exclude_categories').select2();
});

$(function() {

    $(document).on("change",".uploadFile", function()
    {
        alert
    	var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                }
        }
      
    });
});
    </script>
@endsection