@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
    
    <section id="basic-input" class="content-wrapper">
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.teams.store') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="mb-0">Create New Team Member</p>   
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
                                <fieldset class="form-group">
                                    <label for="basicInput">Image</label>
                                    <input id="name" value="{{ old('image') }}" type="file" class="form-control"  name="image" placeholder="Enter name" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name EN</label>
                                    <input id="name" value="{{ old('name_en') }}" type="text" class="form-control"  name="name_en" placeholder="Enter name in english" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Name AR</label>
                                    <input id="name" value="{{ old('name_ar') }}" type="text" class="form-control"  name="name_ar" placeholder="Enter name in english" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Description En</label>
                                    <textarea name="description_en" placeholder="Enter Description in en" class="form-control">{{ old('description_en') }}</textarea>
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Description Ar</label>
                                    <textarea name="description_ar" placeholder="Enter Description in ar" class="form-control">{{ old('description_ar') }}</textarea>
                                </fieldset>

                                <div class="form-group mt-2">
                                    <h5>
                                        Social Media
                                    </h5>
                                </div>
                                <fieldset class="form-group">
                                    <label for="basicInput">Facebook</label>
                                    <input id="name" value="{{ old('face_book_link') }}" type="text" class="form-control"  name="facebook" placeholder="Enter facebook link" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label for="basicInput">Twitter</label>
                                    <input id="name" value="{{ old('twitter_link') }}" type="text" class="form-control"  name="twitter" placeholder="Enter twitter link" />
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