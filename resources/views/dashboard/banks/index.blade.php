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
.createBankButton{
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
                                    <p class="mb-0">Banks</p>
                                </div>

                                <div class="section-right">
                                    <button  onclick="openModalCreateBank()" class="btn btn-secondary">Create</button>
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
                                                    @foreach($data as $item)
                                                        <tr>
                                                            
                                                            <td>{{ $item->getTranslation('name','ar') }}</td>
                                                            <td>{{ $item->getTranslation('name','en') }}</td>
                                                            <td>
                                                                {{-- @can('Edit City') --}}
                                                                    <button onclick="getUserData('{{ $item->id }}','{{$item->getTranslation('name','ar') }}','{{ $item->getTranslation('name','en') }}','{{ $item->countries?$item->countries->id:'0'}}','1')" class="btn btn-secondary">
                                                                        <i class="bx bx-edit"></i>
                                                                    </button>
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
                                {{-- @can('See City') --}}
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
    <div id="createBank" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              
                <div class="modal-body">
                    <h3 id="bank_model_title" class="text-center modal-title">
                        Create Bank
                    </h3>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name Ar</label>
                        <input id="bank_name_ar" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name En</label>
                        <input id="bank_name_en" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name ">
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="addBankApi()" type="button" class="btn btn-primary createBankButton">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Bank!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this '<span id="bankName"></span>' bank ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="deleteApi()" type="button" class="btn btn-danger createBankButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>


    let bank_id = null;

    function openModal(id, name) 
    {
        bank_id = id;
        $('#bankName').empty();
        $('#bankName').append(name);
        $('#deleteModal').modal('toggle');
    };


    function deleteApi() 
    {
        let url = '{{ route("dashboard.banks.delete",":id") }}';
        let updatedUrl = url.replace(':id', bank_id);
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
                console.log('delete faq Error')
            }
        });
    }

    function openModalCreateBank()
    {
        bank_id = null;
        $('#bank_model_title').empty();
        $('#bank_model_title').append('Create Bank');
        $('#bank_name_ar').val('');
         $('#bank_name_en').val('');


        $('#createBank').modal('toggle');
    }

    function getUserData(id,name_ar,name_en)
    {
        bank_id = id;
        $('#bank_model_title').empty();
        $('#bank_model_title').append('Update Area');

        /** 
         * add values
         * 
         * **/

         $('#bank_name_ar').val(name_ar);
         $('#bank_name_en').val(name_en);

        $('#createBank').modal('toggle');


    }
  

    function addBankApi()
    {
        if(!addAreaValdation()) return;
        let url = '{{route("dashboard.banks.store")}}';
        if(bank_id)
        {
            let updateWithId = '{{route("dashboard.banks.update",":id")}}'
            url = updateWithId.replace(':id',bank_id);
        }
        $.ajax({
            url:url,
            type:'POST',
            data:{
                name_ar:document.getElementById('bank_name_ar').value,
                name_en:document.getElementById('bank_name_en').value,
                _token:'{{ csrf_token() }}'
            },
            success:(res)=>{
               window.location.reload();
            },
            error:(err)=>{
                console.log(err)
            }
        })
    }

    function addAreaValdation()
    {
        if(document.getElementById('bank_name_ar').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add bank name in arabic'
            })
            return false;
        }
        if(document.getElementById('bank_name_en').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add bank name in english'
            })
            return false;
        }
        return true;

    }

</script>

@endsection
