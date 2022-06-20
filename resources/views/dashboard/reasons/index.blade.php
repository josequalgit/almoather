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
        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <p class="mb-0">Reasons</p>
                                </div>
                                @can('Create Reasons')
                                <div class="section-right">
                                    <button onclick="openCreateModal()" class=" btn btn-primary float-right">Create</button>                            
                                </div>
                               @endcan
                                <hr class="w-100 my-1">

                            </div>
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    {{-- @can('See Reasons') --}}
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Title Ar</th>
                                                    <th>Title EN</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $item)
                                                        <tr>
                                                            <td>{{ $item->getTranslation('text','ar') }}</td>
                                                            <td>{{ $item->getTranslation('text','en') }}</td>
                                                            <td>
                                                                @can('Delete Reasons')
                                                                    <button class="btn btn-secondary" onclick="openCreateModal('{{ $item->id }}','{{ $item->getTranslation('text','ar') }}','{{ $item->getTranslation('text','en') }}','{{ $item->type }}')">
                                                                        <i class="bx bx-edit  deleteIcon"></i>
                                                                    </button>
                                                                @endcan
                                                                @can('Delete Reasons')
                                                                    <button class="btn btn-danger" onclick="openModal('{{ $item->id }}','{{ $item->getTranslation('text','en') }}')">
                                                                        <i class="bx bx-trash  deleteIcon"></i>
                                                                    </button>
                                                                @endcan

                                                            </td>
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                            {{-- @can('See Reasons') --}}
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
              <h5 class="modal-title">Delete Reason!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="roleName"></span>' reason ?</p>
            </div>
            <div class="modal-footer">
              <button onclick="deleteApi()" type="button" class="btn btn-primary">Delete</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <div id="createModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 id="ModalmodalTitle" class="modal-title">Add Reason!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             {{-- <input id="reason" placeholder="enter reason" class="form-control" /> --}}
             <div class="form-group">
                <label for="exampleInputEmail1">Text Ar</label>
                <input id="reason_ar" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter text">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Text En</label>
                <input id="reason_en" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter text">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Type</label>
                <select id="type" class="form-control form-select form-select-lg" aria-label="Default select example">
                    <option value="influencer" >Influncer</option>
                    <option value="customer" >Customer</option>
                  </select>
                  
              </div>
                        
            </div>
            <div class="modal-footer">
              <button id="addButton" onclick="createReason()" type="button" class="btn btn-primary">Add</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')

<script>
    let reason_id = null;
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

    function openModal(id,name)
    {
        reason_id = id;
        $('#roleName').empty();
        $('#roleName').append(name);
        $('#deleteModal').modal('toggle');
    };

    function openCreateModal(id,reason_ar = null,reason_en = null,type = null)
    {
          
        if(reason_ar)
        {
            reason_id = id;

            $('#reason_ar').val(reason_ar);
            $('#reason_en').val(reason_en);
            $('#ModalmodalTitle').empty();
            $('#ModalmodalTitle').append('Update Reason');
            $('#addButton').empty();
            $('#addButton').append('Update');
            $('#type').val(type);
        }
        else
        {
            reason_id = null;
            $('#reason_ar').val('');
            $('#reason_en').val('');
            $('#type').val('');
            $('#ModalmodalTitle').empty();
            $('#ModalmodalTitle').append('Create Reason');
            $('#addButton').empty();

            $('#addButton').append('Create');
        }
        $('#createModal').modal('toggle');
    }

    function createReason()
    {
        let route = '{{ route("dashboard.reasons.store") }}';
        if(reason_id)
        {
            route = '{{ route("dashboard.reasons.update",":id") }}'
            route = route.replace(':id',reason_id);
        }
       
        $.ajax({
            url:route,
            type:'POST',
            data:{
                _token:'{{csrf_token()}}',
                reason_ar:document.getElementById('reason_ar').value,
                reason_en:document.getElementById('reason_en').value,
                type:document.getElementById('type').value
            },
            success:(res)=>{
                location.reload();
            },
            error:(res)=>{
                console.log('error response...')
            }
        });
    }

    function deleteApi()
    {
        let url = '{{ route("dashboard.reasons.delete",":id") }}';
        let updatedUrl = url.replace(':id',reason_id);
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
