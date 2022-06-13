@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.roles.update',$data->id) }}">
                @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Update Roles</p>
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
                                        <input id="name" value="{{ old('name') ? old('name'):$data->name }}" type="text" class="form-control"  name="name" placeholder="Enter name" />
                                    </fieldset>
        
                                   
        
                                </div>
                               <div class="col">
                                   <h6>
                                       Permissions
                                   </h6>
                                   <div class="row">
                                      
                                       @foreach ($allPermissions as $item)
                                      
                                       <div class="col-6">
                                           <div id="checkBox{{ $item->id }}" class="form-check form-check-inline">
                                            {{-- <input name="permission[]" class="form-check-input" {{ (in_array($item->id, $permissionIds))?'checked': ''}} type="checkbox" id="inlineCheckbox{{$item->id}}" value="{{ $item->id }}"> --}}
                                            <input name="permission[]" {{ (in_array($item->id, $permissionIds))?'checked': ''}} id="inlineCheckbox{{$item->id}}" value="{{ $item->id }}" type="checkbox" data-toggle="toggle" data-onstyle="primary">
    
                                            <label class="form-check-label ml-2" for="inlineCheckbox1">{{ $item->name }}</label>
                                          </div>
                                       </div>
                                       @endforeach
                                      
                                   </div>
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