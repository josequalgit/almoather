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
                                    <p class="mb-0">Notifications</p>
                                </div>
                                <div class="section-right">
                                    @can('Create Notification')
                                        <a href="{{ route('dashboard.notifications.create') }}" class=" btn btn-primary float-right">Create</a>                            
                                    @endcan
                                </div>
                                <hr class="w-100">
                            </div>
                            <div class="card-body card-dashboard">                            
                                <div class="table-responsive">
                                    @can('See Notification')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Message</th>
                                                    <th>Was Sent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $item->data['msg'] }}</td>
                                                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Notification')
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
              
            },
            error:(err)=>{
                console.log('delete role Error')
            }
        });
    }
</script>

@endsection
