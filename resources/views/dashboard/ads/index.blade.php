@extends('dashboard.layout.index')

@section('content')
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
                            <li class="breadcrumb-item active">Ads
                            </li>
                        </ol>
                        {{-- @can('Create Influncer')
                            <a href="{{ route('dashboard.ads.create') }}" class=" btn btn-primary float-right">Create</a>                            
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
                                <h4 class="card-title">ads</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                @can('See Ads')
                                <p class="card-text">
                                    There is {{ $counter }} ad/'s
                                </p>
                                @endcan
                                <div class="table-responsive">
                                    @can('See Ads')
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Store</th>
                                                <th>Budget</th>
                                                <th>On Site</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                    <tr>
                                                        <td style="text-transform: uppercase;">{{ $item->type  }}</td>
                                                        <td>{{ $item->store }}</td>
                                                        <td>{{ $item->budget }}</td>
                                                        <td>{{ $item->onsite ? 'Yes':'No' }}</td>
                                                        <td style="text-transform: uppercase;">{{ $item->status }}</td>
                                                        <td>
                                                           @can('Edit Ads')
                                                            <a href="{{ route('dashboard.ads.edit',$item->id) }}">
                                                                <i class="bx bx-show"></i>
                                                            </a>                                                               
                                                           @endcan
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Ads')
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
              <h5 class="modal-title">Delete Influncer!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="adminInfluncerModal"></span>' ?</p>
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
    let admin_id = null;

    function openModal(id,name)
    {
        admin_id = id;
        $('#adminInfluncerModal').empty();
        $('#adminInfluncerModal').append(name);
        $('#deleteModal').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.admins.delete",":id") }}';
        let updatedUrl = url.replace(':id',admin_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                location.reload();
            },
            error:(err)=>{
                console.log('delete admin Error')
            }
        });
    }
</script>

@endsection
