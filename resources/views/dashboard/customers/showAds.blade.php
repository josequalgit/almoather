@extends('dashboard.layout.index')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        
        <div class="content-body">
            <!-- Basic tabs start -->
            @can('See Customer')
            <div class="row">
                <div class="col-12 col-sm-7">
                    <div class="media mb-2">
                        {{-- @php
                            dd($customer->users->image['url']);
                        @endphp --}}
                        <a class="mr-1" href="javascript:void(0);">
                            <img src="{{ $customer->users->image['url'] }}" alt="users view avatar" class="users-avatar-shadow rounded-circle" height="64" width="64">
                        </a>
                        <div class="media-body pt-25">
                            <h4 class="media-heading"><span class="users-view-name">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
                            <span>Type:</span>
                            <span class="users-view-id">Customer</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                    {{-- <a href="javascript:void(0);" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
                    <a href="javascript:void(0);" class="btn btn-sm mr-25 border">Profile</a> --}}
                    <a href="{{ route('dashboard.customers.edit',$customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Registered:</td>
                                        <td>{{ $customer->created_at->isoFormat('D/M/Y') }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Latest Activity:</td>
                                        <td class="users-view-latest-activity">30/04/2019</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Verified:</td>
                                        <td class="users-view-verified">Yes</td>
                                    </tr> --}}
                                    <tr>
                                        <td>Role:</td>
                                        <td class="users-view-role">Customer</td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td><span class="badge badge-light-{{ $customer->status == 'active'?'success':'danger' }} users-view-status">{{ $customer->status }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="table-responsive">
                                <table class="table mb-0">
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
                                        @foreach ($ads as $item)
                                            <tr>
                                                <td style="text-transform: uppercase;">{{ $item->type  }}</td>
                                                <td>{{ $item->store }}</td>
                                                <td>{{ $item->budget }}</td>
                                                <td>{{ $item->onsite ? 'Yes':'No' }}</td>
                                                <td style="text-transform: uppercase;">{{ $item->status }}</td>
                                                <td>
                                                @can('Edit Ads')
                                                    <a  class="btn btn-secondary" href="{{ route('dashboard.ads.edit',$item->id) }}">
                                                        <i class="bx bx-show"></i>
                                                    </a>                                                               
                                                @endcan
                                                </td>
                                            </tr>
                                     @endforeach
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ads</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                @can('See Customer')
                                 <p class="card-text">
                                    There is {{ $counter }} Ad/'s
                                </p>
                                @endcan
                                <div class="table-responsive">
                                    @can('See Customer')
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
                                                    <a  class="btn btn-secondary" href="{{ route('dashboard.ads.edit',$item->id) }}">
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
                            @can('See Customer')
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
              <h5 class="modal-title">Delete Customers!</h5>
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
