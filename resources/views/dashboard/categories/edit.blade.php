@extends('dashboard.layout.index')
@section('content')
<style>
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
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.categories.update',$data->id) }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update Categories</h4>
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
                                    <label for="basicInput">Name EN</label>
                                    <input id="name" value="{{ old('name_en')?old('name_en'):$data->getTranslations('name')['en'] }}" type="text" class="form-control"  name="name_en" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name AR</label>
                                    <input id="name" value="{{ old('name_ar')?old('name_ar'):$data->getTranslations('name')['ar'] }}" type="text" class="form-control"  name="name_ar" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Type</label>
                                    <div class="form-group">
                                        <select  name='type' class="form-control" id="exampleFormControlSelect1">
                                          <option {{ $data->type == 'service'?'selected':'' }} value="service">Service</option>
                                          <option {{ $data->type == 'product'?'selected':'' }} value="product">Product</option>
                                        </select>
                                      </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Influencer Category</label>
                                    <div class="form-group">
                                   
                                        {{-- <select  multiple name='influncer_category_id[]' class="form-control" id="exampleFormControlSelect1">
                                            @foreach ($categories as $item)
                                            <option  {{ in_array($item->id,$selectedCategories) ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select> --}}
                                        <select multiple id="influncer_category_id" name='influncer_category_id[]' class="categories form-control" name="state">
                                            @foreach ($categories as $item)
                                            <option  {{ in_array($item->id,$selectedCategories) ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                          </select>
                                          
                                      </div>
                                </fieldset>

                                <fieldset class="form-group">
                                    <label for="basicInput">Preferred Category</label>
                                    <div class="form-group">
                                        <select  multiple name='preferred_categories[]' class="form-control preferred_categories" id="preferred_categories">
                                            @foreach ($categories as $item)
                                            <option  {{ in_array($item->id,$preferredCategories) ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                      </div>
                                </fieldset>

                                <fieldset class="form-group">
                                    <label for="basicInput">Exclude Category</label>
                                    <div class="form-group">
                                        <select  multiple name='exclude_categories[]' class="form-control exclude_categories" id="exclude_categories">
                                            @foreach ($categories as $item)
                                            <option {{ in_array($item->id,$excludeCategories) ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>                                                
                                            @endforeach
                                        </select>
                                      </div>
                                </fieldset>
                               
    
                            </div>
                        
                        </div>
                        <hr/>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
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
        // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.categories').select2();
    $('.preferred_categories').select2();
    $('.exclude_categories').select2();
});

        var img = '{{ $data->image }}';
 $('.imagePreview').css("background-image", `url("${img}")`);

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