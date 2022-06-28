@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.slides.store') }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Create Slides</p>
                            </div>
                            <hr class="w-100 my-1">

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
                                  
                                    <fieldset class="form-group d-flex justify-content-center">
                                        
                                        <div class="col-7 imgUp">
                                            <div class="imagePreview"></div>
                                        <label class="btn btn-primary">
                                                Upload<input name="image" type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                                        </label>
                                          </div>
                                        
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Title EN</label>
                                        <input id="title_en" value="{{ old('title_en') }}" type="text" class="form-control"  name="title_en" placeholder="Enter title" />
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Title AR</label>
                                        <input id="title_ar" value="{{ old('title_ar') }}" type="text" class="form-control"  name="title_ar" placeholder="Enter name" />
                                    </fieldset>
    
    
    
                                    <fieldset class="form-group">
                                        <label for="basicInput">Description En</label>
                                        <textarea name="description_en" class="form-control">{{ old('description_en') }}</textarea>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Description AR</label>
                                        <textarea name="description_ar" class="form-control">{{ old('description_ar') }}</textarea>
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

      
</div>

@endsection

@section('scripts')
    <script>
    
$(function() {

    $(document).on("change",".uploadFile", function()
    {
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