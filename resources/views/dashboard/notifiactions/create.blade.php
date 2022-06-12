@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <section id="basic-input">
            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.notifications.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title">
                                    <p class="mb-0">Create Notification</p>
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
                                            <label for="basicInput">Message</label>
                                            {{-- <input id="name" value="{{ old('name') }}" type="text" class="form-control"  name="name" placeholder="Enter name" /> --}}
                                            <textarea placeholder="Enter a message" name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>

                                        </fieldset>
                                        
                                        <fieldset class="form-group">
                                            <label for="basicInput">Users</label>
                                            <select name="users" class="form-control" id="exampleFormControlSelect1">
                                                <option value="all" >All</option>
                                                @foreach ($data as $user)
                                                @if($user->id != auth()->user()->id)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endif
                                                @endforeach                                       
                                            </select>
                                        </fieldset>
                                    
            
                                    </div>
                                
                                </div>
                                <hr/>
                                <button type="submit" class="btn btn-primary float-right">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection