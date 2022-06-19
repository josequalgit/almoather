@extends('dashboard.layout.index')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.roles.store') }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Create Roles</p>
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
                                        <label for="basicInput">Name</label>
                                        <input id="name" value="{{ old('name') }}" type="text" class="form-control"  name="name" placeholder="Enter name" />
                                    </fieldset>
        
                                   
        
                                </div>
                               <div class="col">
                                   <button id="checkAllButton" onclick="checkAll()" type="button" class="btn btn-success mb-2">Check All</button>
                                   <button id="unCheckAllButton" onclick="unCheckAll()" type="button" class="btn btn-secondary mb-2">Uncheck All</button>
                                   <h6>
                                       Permissions
                                   </h6>
                                   <div class="row">
                                       @foreach ($data as $item)
                                       <div class="col-6">
                                           <div id="checkBox{{ $item->id }}" class="form-check form-check-inline">
                                            <input class="checkboxAll" name="permission[]" id="inlineCheckbox{{$item->id}}" value="{{ $item->id }}" type="checkbox" data-toggle="toggle" data-onstyle="primary">
    
                                            {{-- <input name="permission[]" class="form-check-input" type="checkbox" id="inlineCheckbox{{$item->id}}" value="{{ $item->id }}"> --}}
                                            <label  class="form-check-label ml-2" for="checkBox{{ $item->id }}">{{ $item->name }}</label>
                                          </div>
                                       </div>
                                       @endforeach
                                      
                                   </div>
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
    $('#unCheckAllButton').hide();
   function checkAll() {
    $('#unCheckAllButton').show();
     $('#checkAllButton').hide();

     $('.checkboxAll').prop('checked', true).change();
    }
   function unCheckAll() {
     $('.checkboxAll').prop('checked', false).change();
     $('#unCheckAllButton').hide();
     $('#checkAllButton').show();

    }

</script>
@endsection