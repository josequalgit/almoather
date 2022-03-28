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
                            <li class="breadcrumb-item active">Social Media
                            </li>
                        </ol>
                        {{-- @can('Create Role')
                        <a href="{{ route('dashboard.roles.create') }}" class=" btn btn-primary float-right">Create</a>                            
                        @endcan --}}
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
                                <h4 class="card-title">Social Media</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                             
                                <div class="table-responsive">
                                    @can('See SocialMedia')
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
                                                                {{-- @can('Delete Role')
                                                                    <a href="{{ route('dashboard.roles.edit',$item->id) }}">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                @endcan --}}
                                                                @can('Edit SocialMedia')
                                                                    <button class="btn btn-{{$item->active?'success':'danger'}}" onclick="openModal('{{ $item->id }}','{{ $item->name }}')">
                                                                        {{ $item->active ? 'Active' : 'Not Active' }}
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
                            @can('See SocialMedia')
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
              <h5 class="modal-title">Change Social Media Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to change '<span id="socialMediaName"></span>' status?</p>
            </div>
            <div class="modal-footer">
              <button onclick="changeApi()" type="button" class="btn btn-primary">Change</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')

<script>
    let socialMedia_id = null;
    let new_status = null;

    function openModal(id,name,status)
    {
        socialMedia_id = id;
        new_status = status;
        $('#socialMediaName').empty();
        $('#socialMediaName').append(name);
        $('#deleteModal').modal('toggle');
    };

    function changeApi()
    {
        let url = '{{ route("dashboard.socialMedia.update",":id") }}';
        let updatedUrl = url.replace(':id',socialMedia_id);
        $.ajax({
            type:'POST',
            url:updatedUrl,
            data:{
                "_token": "{{ csrf_token() }}",
            },
            success:(res)=>{
                if(!res.err)
                {
                    location.reload();
                }
              
            },
            error:(err)=>{
                console.log('delete social media Error')
            }
        });
    }
</script>

@endsection
