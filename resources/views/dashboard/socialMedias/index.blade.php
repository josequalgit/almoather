@extends('dashboard.layout.index')

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
     
        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <p class="mb-0">Social Media</p>
                                    <hr class="w-100 my-1">

                                </div>
                            </div>
                            <div class="card-body card-dashboard">
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
