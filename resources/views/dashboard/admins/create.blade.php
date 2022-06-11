@extends('dashboard.layout.index')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <section id="basic-input">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <p class="mb-0">Create Admin</p>
                        </div>
                        
                        <hr class="w-100">
                    </div>
                    <div class="card-body card-dashboard">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert"> There is something wrong
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Email</label>
                                    <input value="{{ old('email') }}" name="email" type="email" class="form-control"
                                        id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Password</label>
                                    <input value="{{ old('password') }}" name="password" type="password" class="form-control"
                                        id="inputPassword4" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Roles</label>
                                <div class="form-group">
                                    <select value="{{ old('role') }}" name="role" class="form-control"
                                        id="exampleFormControlSelect1">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress2">Name</label>
                                <input value="{{ old('name') }}" name="name" type="text" class="form-control"
                                    id="inputAddress2" placeholder="Add the admin name">
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
