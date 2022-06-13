@extends('dashboard.layout.index')
@section('content')
<style>
    body
{
  background-color:#f5f5f5;
}
.imagePreview {
    width: 100%;
    height: 180px;
    background-position: center center;
  background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
  background-color:#fff;
    background-size: cover;
  background-repeat:no-repeat;
    display: inline-block;
  box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
}
.btn-primary
{
  display:block;
  border-radius:0px;
  box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
  margin-top:-5px;
}
.imgUp
{
  margin-bottom:15px;
}
.del
{
  position:absolute;
  top:0px;
  right:15px;
  width:30px;
  height:30px;
  text-align:center;
  line-height:30px;
  background-color:rgba(255,255,255,0.6);
  cursor:pointer;
}
.imgAdd
{
  width:30px;
  height:30px;
  border-radius:50%;
  background-color:#4bd7ef;
  color:#fff;
  box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
  text-align:center;
  line-height:30px;
  margin-top:0px;
  cursor:pointer;
  font-size:15px;
}
</style>
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
                                        {{-- <label for="basicInput">Icon</label>
                                        <input id="icon" value="{{ old('icon') }}" type="file" class="form-control"  name="icon" placeholder="add icon" /> --}}
                                        <div class="col-7 imgUp">
                                            <div class="imagePreview"></div>
                                        <label class="btn btn-primary">
                                                Upload<input name="image" type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                                        </label>
                                          </div><!-- col-2 -->
                                        
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