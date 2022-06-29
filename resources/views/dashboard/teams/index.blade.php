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
                            <div class="card-header pb-0">
                                <div class="card-title">
                                    <p class="mb-0">Teams</p>
                                  
                                </div>
                                <div class="section-right">
                                    <a href="{{ route('dashboard.teams.create') }}" class="btn btn-secondary">Create</a>
                                </div>
                                <hr class="w-100 my-1">
                            </div>
                            
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    {{-- @can('See Faq') --}}
                                    <table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                               
                                                <th><span class="align-middle">Avatar</span></th>
                                                <th><span class="align-middle">Name</span></th>
                                                <th>Description</th>
                                                <th>Social Media</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                  <img height="50px" class="rounded-circle" src=" {{ $item->image['url'] }}" alt="">
                                                </td>
                                                <td>
                                                   {{ $item->name }}
                                                </td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    Twitter: {{$item->accounts->twitter}}<br/>
                                                    FaceBook: {{$item->accounts->facebook}}
                                                </td>
                                                <td>
                                                    {{-- @can('Edit City') --}}
                                                    <a  href="{{ route('dashboard.teams.edit',$item->id) }}" class="btn btn-secondary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                {{-- @endcan --}}
                                                {{-- @can('Delete City') --}}
                                                    <button class="btn btn-danger"
                                                        onclick="openModal('{{ $item->id }}','{{ $item->name }}')">
                                                        <i class="bx bx-trash buttonIcon"></i>
                                                    </button>
                                                {{-- @endcan --}}
                                                </td>
                                            </tr>
                                                
                                            @endforeach
                                         
                                        </tbody>
                                    </table>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                            {{-- @can('See Faq') --}}
                            <div class="p-1">
                                {{ $data->links('pagination::bootstrap-5') }}
                            </div>
                            {{-- @endcan --}}
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
              <h5 class="modal-title">Delete Faq!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="member_name"></span>' member ?</p>
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
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
    })

      function openModal(id, name) 
    {
        city_id = id;
        $('#member_name').empty();
        $('#member_name').append(name);
        $('#deleteModal').modal('toggle');
    };


    function deleteApi() 
    {
        let url = '{{ route("dashboard.teams.delete",":id") }}';
        let updatedUrl = url.replace(':id', city_id);
        $.ajax({
            type: 'POST',
            url: updatedUrl,
            data:{
                _token:'{{ csrf_token() }}'
            },
            success: (res) => {
                if (!res.err) {
                    location.reload();
                }

            },
            error: (err) => {
                Swal.fire({
                        title: 'Deleteing Error!',
                        text:'There is something wrong with deleteing the member',
                        icon: 'error',
                        toast:true,
                        position:'top-right',
                        showConfirmButton:false,
                        timer: 10000,

                    })
            }
        });
    }

</script>
@endsection
