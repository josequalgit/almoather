@extends('dashboard.layout.index')

@section('content')
<style>
    .table-longText{
        width: 65%;
    }
    .titleSection{
        width: 15%;
        -webkit-line-clamp: 2;
    }
</style>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="breadcrumbs-top">
                    <h5 class="content-header-title float-left pr-1 mb-0">Tabs</h5>
                    <div class="breadcrumb-wrapper d-none d-sm-block">
                        <ol class="breadcrumb p-0 mb-0 pl-1">
                            <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Categories
                            </li>
                        </ol>
                        @can('Create Category')
                        <a href="{{ route('dashboard.categories.create') }}" class=" btn btn-primary float-right">Create</a>                            
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body mt-5">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Categories</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                             
                                <div class="table-responsive">
                                    @can('See Category')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                            <td>
                                                                <img height="50px" width="150px" src="{{ $item->image }}" />
                                                            </td>
                                                            <td>{{ $item->name }}</td>
                                                            
                                                            <td>
                                                                @can('Delete Category')
                                                                    <a href="{{ route('dashboard.categories.edit',$item->id) }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Edit Category')
                                                                    <button style="background: none; border:none;" onclick="openModal('{{ $item->id }}','{{ $item->name }}')">
                                                                        <i class="bx bx-trash text-danger"></i>
                                                                    </button>
                                                                @endcan

                                                            </td>
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Category')
                            {{ $data->links() }}
                            @endcan
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Role!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="categoryName"></span>' role ?</p>
            </div>
            <div class="modal-footer">
              <button onclick="deleteApi()" type="button" class="btn btn-primary">Delete</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')

<script>
    let role_id = null;

    function openModal(id,name)
    {
        role_id = id;
        $('#categoryName').empty();
        $('#categoryName').append(name);
        $('#deleteModal').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.categories.delete",":id") }}';
        let updatedUrl = url.replace(':id',role_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                if(!res.err)
                {
                    location.reload();
                }
              
            },
            error:(err)=>{
                console.log('delete role Error')
            }
        });
    }
</script>

@endsection
