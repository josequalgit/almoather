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

<div class="app-content content p-5 mt-5">
    
    <section id="basic-input">
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.influencerCategories.store') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Influencer Categories</h4>
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
                                      </div><!-- col-2 -->
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name EN</label>
                                    <input id="name" value="{{ old('name_en') }}" type="text" class="form-control"  name="name_en" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name AR</label>
                                    <input id="name" value="{{ old('name_ar') }}" type="text" class="form-control"  name="name_ar" placeholder="Enter name" />
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