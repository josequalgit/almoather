@extends('dashboard.layout.index')
@section('content')

<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.faqs.update',$data->id) }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Update Faq</p>
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
                                 
                                    <fieldset class="form-group">
                                        <label for="basicInput">Question En</label>
                                        <input id="question_en" value="{{ old('question_en')?old('question_en'):$data->getTranslation('question','en') }}" type="text" class="form-control"  name="question_en" placeholder="Enter question" />
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Answer En</label>
                                        <textarea  class="form-control" name="answer_en">{{ old('answer_en')?old('answer_en'):$data->getTranslation('answer','en')}}</textarea>
                                    </fieldset>
                                 
        
                                   
        
                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-12">
                                 
                                    <fieldset class="form-group">
                                        <label for="basicInput">Question Ar</label>
                                        <input id="question_ar" value="{{ old('question_ar')?old('question_ar'):$data->getTranslation('question','ar') }}" type="text" class="form-control"  name="question_ar" placeholder="Enter question" />
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Answer Ar</label>
                                        <textarea  class="form-control" name="answer_ar">{{ old('answer_ar')?old('answer_ar'):$data->getTranslation('answer','ar') }}</textarea>
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