@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.campaignGoals.store') }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Create Campaing Goal</p>
                            </div>
                            <hr class="w-100">
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
                                        <label for="basicInput">En</label>
                                        <input id="campaing_goal_en" value="{{ old('campaing_goal_en') }}" type="text" class="form-control"  name="campaing_goal_en" placeholder="Enter campaing goal" />
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Ar</label>
                                        <input id="campaing_goal_ar" value="{{ old('campaing_goal_ar') }}" type="text" class="form-control"  name="campaing_goal_ar" placeholder="Enter campaing goal" />
                                    </fieldset>
    
                                    <fieldset class="form-group row p-2">
                                        <label for="basicInput">Can Customer Review</label>
                                        <input id="customer_can_review"  value="1" type="checkbox" class="form-control w-25"  name="profitable" placeholder="Enter campaing goal" />
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