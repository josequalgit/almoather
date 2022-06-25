@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.contracts.update',1) }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Update Contract(Influncer)</p>
                            </div>
                            <hr class="w-100">
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
                                        <label for="basicInput">Last time was updated {{ $data->updated_at->diffForHumans() }}</label>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Data</label>
                                        <textarea name="content" id="editor1" rows="10" cols="80">
                                            {{ json_decode($data->value) }}
                                        </textarea>                        
                                    </fieldset>
                                </div>
                            </div>
                       
                            <hr/>
                            <button type="submit" class="btn btn-secondary float-right">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </section>
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.contracts.update',2) }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Update Contract(Cutomer)</p>
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
                                        <label for="basicInput">Last time was updated {{ $data2->updated_at->diffForHumans() }}</label>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="basicInput">Data</label>
                                        <textarea name="content" id="editor2" rows="10" cols="80">
                                            {{ json_decode($data2->value) }}
                                        </textarea>                        
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
   CKEDITOR.replace('editor1', {
        extraPlugins: 'justify,placeholder,colorbutton,font',
      height: 600,
      contentsLangDirection: 'rtl',
      removeButtons: 'PasteFromWord'
    });
   CKEDITOR.replace('editor2', {
        extraPlugins: 'justify,placeholder,colorbutton,font',
      contentsLangDirection: 'rtl',
      height: 600,
      removeButtons: 'PasteFromWord'
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