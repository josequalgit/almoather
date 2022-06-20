@extends('dashboard.layout.index')

@section('content')
<style>
    .table-longText {
        width: 65%;
    }

    .titleSection {
        width: 15%;
        -webkit-line-clamp: 2;
    }
    .modal-dialog {
        max-width: 50% !important;
    margin: 1.75rem auto;
}
.createCityButton{
    margin-top: 4px;
    border-radius: 3px;
}

</style>
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
                                    <p class="mb-0">Ad Relations</p>
                                </div>

                                <div class="section-right">
                                    <button  onclick="openModalCreateRelation()" class="btn btn-secondary">Create</button>
                                </div>
                                <hr class="w-100 my-1">
                                <div class="w-100 card-dashboard">
                                    <div class="table-responsive">
                                        {{-- @can('See City') --}}
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Name Ar</th>
                                                        <th>Name En</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data as $key => $item)
                                                        <tr>
                                                         
                                                            <td>{{ $item->ar }}</td>
                                                            <td>{{ $item->en }}</td>
                                                            <td>
                                                                {{-- @can('Edit City') --}}
                                                                    <button onclick="getUserData('{{ $key }}','{{$item->ar }}','{{ $item->en }}')" class="btn btn-secondary">
                                                                        <i class="bx bx-edit"></i>
                                                                    </button>
                                                                {{-- @endcan --}}
                                                                {{-- @can('Delete City') --}}
                                                                    <button class="btn btn-danger"
                                                                        onclick="openModal('{{ $key }}','{{ $item->ar }}')">
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
                                {{-- @can('See City') --}}
                                    <div class="p-1">
                                       
                                    </div>
                                {{-- @endcan --}}
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </div>

    

    <div id="addNewData" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Relation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="mb-2">
                        <label for="name_en" class="form-label">Name En</label>
                        <input type="text" class="form-control" id="name_en" placeholder="please add the relation name in english">
                      </div>
                    <div class="mb-2">
                        <label for="name_ar" class="form-label">Name Ar</label>
                        <input type="text" class="form-control" id="name_ar" placeholder="please add the relation name in arabic">
                      </div>
                      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button id="createButton" onclick="createAdRelation()" type="button" class="btn btn-secondary createCityButton">Create</button>
                </div>
            </div>
        </div>
    </div>
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Relation!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this '<span id="relationName"></span>' relation ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="deleteApi()" type="button" class="btn btn-danger createCityButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>
    let editId = null;
    function openModal(id, name) 
    {
        editId = id;
        $('#relationName').empty();
        $('#relationName').append(name);
        $('#deleteModal').modal('toggle');
    };
    
    function openModalCreateRelation()
    {
        $('#addNewData').modal('toggle');
        $('#createButton').empty();
        document.getElementById('name_en').value = '';
        document.getElementById('name_ar').value = '';

        $('#createButton').append('Create');

    }

    function createAdRelation()
    {
        let url = '{{ route("dashboard.adRelations.update") }}';
        if(editId){
            url = '{{ route("dashboard.adRelations.update",":id") }}';
            url = url.replace(':id',editId)
        };
        
        $.ajax({
            type:'POST',
           url,
            data:{
                _token:'{{ csrf_token() }}',
                relation:{
                    ar:document.getElementById('name_ar').value,
                    en:document.getElementById('name_en').value
                }
            },
            success:(res)=>{
                editId = null;
                window.location.reload()
            },
            error:(err)=>{console.log(err)}
        })
    }

    function getUserData(index , name_ar , name_en)
    {
        editId = index;
        document.getElementById('name_en').value = name_en;
        document.getElementById('name_ar').value = name_ar;
        $('#createButton').empty();
        $('#createButton').append('Update');

        $('#addNewData').modal('toggle');
    }
    
    function deleteApi() 
    {
        let url = '{{ route("dashboard.adRelations.delete",":id") }}';
        let updatedUrl = url.replace(':id', editId);
        $.ajax({
            type: 'POST',
            url: updatedUrl,
            data:{
                _token:'{{ csrf_token() }}'
            },
            success: (res) => {
                    location.reload();
            },
            error: (err) => {
                console.log('delete faq Error')
            }
        });
    }
    
  
 

 
</script>

@endsection
