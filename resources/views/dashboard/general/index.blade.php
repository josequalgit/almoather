@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
<div class="content-wrapper">
    <section id="basic-input">
        {{-- @can('Edit Contact Us') --}}
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.generals.update') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <p class="mb-0">General</p>
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
                    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Cancel days period</label>
                                  <input value="{{ old('canceled_days_period')?old('canceled_days_period'):$data['canceled_days_period'] }}" name="canceled_days_period" type="text" class="form-control" id="inputEmail4" placeholder="Enter Name">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">Warning days period</label>
                                  <input value="{{ old('warning_days_period')?old('warning_days_period'):$data['warning_days_period'] }}" name="warning_days_period" type="text" class="form-control" id="inputPassword4" placeholder="Enter Title">
                                </div>
                              </div>
                              <hr/>
                              <button type="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                       
                    </div>
            </div>
        </div>
        </form>
        {{-- @endcan --}}
    
    </section>

</div>


      
</div>

@endsection