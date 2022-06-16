@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
    
    <section id="basic-input" class="content-wrapper">
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.influencerCategories.update',$data->id) }}">
            @csrf
            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Update Influencer Category</p>   
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
                                <input id="name" value="{{ old('name_en')?old('name'):$data->getTranslations('name')['en'] }}" type="text" class="form-control"  name="name_en" placeholder="Enter name" />
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="basicInput">Name AR</label>
                                <input id="name" value="{{ old('name_ar')?old('name'):$data->getTranslations('name')['ar'] }}" type="text" class="form-control"  name="name_ar" placeholder="Enter name" />
                            </fieldset>


                        </div>
                    
                    </div>
                    <hr/>
                    <button type="submit" class="btn btn-primary float-right">Update</button>
                </div>
            </div>
        </form>
    </section> 
</div>

@endsection

@section('scripts')
    <script>
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