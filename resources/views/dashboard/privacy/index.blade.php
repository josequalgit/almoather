@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
<div class="content-wrapper">
    <section id="basic-input">
        @can('Edit Contact Us')
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.contactUs.updatePrivacy') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <p class="mb-0">Update Privacy</p>
                        </div>
                    </div>
                    
                    <hr class="w-100 my-1">
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert"> There is something wrong
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                    
                                <div class="form-group col">
                                  <label for="inputEmail4">Text Ar</label>
                                  <textarea name="text_ar" class="form-control" id="text_ar" rows="3">
                                      {{ $data->getTranslation('text','ar') }}
                                  </textarea>
                                  {{-- <input value="{{ old('name')?old('name'):$data->name }}" name="name" type="text" class="form-control" id="inputEmail4" placeholder="Enter Name"> --}}
                                </div>
                                <div class="form-group col">
                                  <label for="inputPassword4">Text EN</label>
                                  <textarea name="text_en" class="form-control" id="text_en" rows="3">
                                    {{ $data->getTranslation('text','en') }}
                                  </textarea>
                                  {{-- <input value="{{ old('title')?old('title'):$data->title }}" name="title" type="text" class="form-control" id="inputPassword4" placeholder="Enter Title"> --}}
                                </div>
                             
                             
                              <hr/>
                              <button type="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                       
                    </div>
            </div>
        </div>
        </form>
        @endcan
     
    </section>

</div>


      
</div>


@endsection

@section('scripts')
<script>
     CKEDITOR.replace('text_ar', {
      extraPlugins: 'placeholder',
      height: 220,
      removeButtons: 'PasteFromWord'
    });
     CKEDITOR.replace('text_en', {
      extraPlugins: 'placeholder',
      height: 220,
      removeButtons: 'PasteFromWord'
    });
</script>
@endsection