@extends('dashboard.layout.index')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title">
                                    <p class="mb-0">Roles</p>
                                </div>
                                <div class="section-right">
                                    @can('Create Role')
                                        <a href="{{ route('dashboard.roles.create') }}" class=" btn btn-primary float-right">Create</a>                            
                                    @endcan
                                </div>
                                <hr class="w-100">
                            </div>
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    @can('See Role')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                    @if($item->id != 1)
                                                        <tr>
                                                            <td>{{ $item->name }}</td>
                                                            
                                                            <td>
                                                                @can('Edit Role')
                                                                    <a class="btn btn-secondary" href="{{ route('dashboard.roles.edit',$item->id) }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Delete Role')
                                                                    <button class="btn btn-danger" onclick="openModal('{{ $item->id }}','{{ $item->name }}')">
                                                                        <i class="bx bx-trash  deleteIcon"></i>
                                                                    </button>
                                                                @endcan

                                                            </td>
                                                        
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Role')
                            <div class="p-1">
                                {{ $data->links('pagination::bootstrap-5') }}
                            </div>
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
              <p>Are you sure you want to delete this  '<span id="roleName"></span>' role ?</p>
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
        $('#roleName').empty();
        $('#roleName').append(name);
        $('#deleteModal').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.roles.delete",":id") }}';
        let updatedUrl = url.replace(':id',role_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                if(!res.err)
                {
                    location.reload();
                }
               if(res.err)
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
