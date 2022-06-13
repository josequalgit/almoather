@extends('dashboard.layout.index')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                        <div class="card-header w-100">
                                            <div class="card-title">
                                                <p class="mb-0">Social Media</p>
                                            </div>
                                            <hr class="w-100 my-1">
                                        </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @can('See SocialMedia')
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                        @if($item->id != 1)
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
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
