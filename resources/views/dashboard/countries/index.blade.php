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
                                    <p class="mb-0">Country</p>
                                </div>

                                <div class="section-right">
                                    <button  onclick="openModalCreateCity()" class="btn btn-secondary">Create</button>
                                </div>
                                <hr class="w-100 my-1">
                                <div class="w-100 card-dashboard">
                                    <div class="table-responsive">
                                        {{-- @can('See City') --}}
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Name AR</th>
                                                        <th>Name EN</th>
                                                        <th>Phone Code</th>
                                                        <th>Code</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            
                                                            <td>{{ $item->getTranslation('name','ar') }}</td>
                                                            <td>{{ $item->getTranslation('name','en') }}</td>
                                                            <td>{{ $item->country_code }}</td>
                                                            <td>{{ $item->code }}</td>
                                                            <td>
                                                                {{-- @can('Edit City') --}}
                                                                    <button onclick="getUserData('{{ $item->id }}','{{$item->getTranslation('name','ar') }}','{{ $item->getTranslation('name','en') }}','{{$item->code }}','{{$item->country_code }}')" class="btn btn-secondary">
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
    <div id="createCity" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              
                <div class="modal-body">
                    <h3 id="country_model_title" class="text-center modal-title">
                        Create Country
                    </h3>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name Ar</label>
                        <input id="country_name_ar" type="email" class="form-control" id="exampleFormControlInput1" placeholder="add data... ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name En</label>
                        <input id="country_name_en" type="email" class="form-control" id="exampleFormControlInput1" placeholder="add data... ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Code</label>
                        <input id="code" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add data... ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Country code</label>
                        <input id="country_code" type="number" class="form-control" id="exampleFormControlInput1" placeholder="add data... ">
                      </div>
                    
                      {{-- <div class="mb-1">
                        <label for="exampleFormControlTextarea1" class="form-label">Region</label>
                        <select  placeholder="here" id="region_selecter" disabled class="form-control" aria-label="Default select example">
                        </select>
                          
                      </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="addAreaApi()" type="button" class="btn btn-primary createCityButton">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Country!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this '<span id="faqName"></span>' country ?</p>
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


    let city_id = null;

    function openModal(id, name) 
    {
        city_id = id;
        $('#faqName').empty();
        $('#faqName').append(name);
        $('#deleteModal').modal('toggle');
    };


    function deleteApi() 
    {
        let url = '{{ route("dashboard.countries.delete",":id") }}';
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
                console.log('delete faq Error')
            }
        });
    }

    function openModalCreateCity()
    {
        city_id = null;
        $('#country_model_title').empty();
        $('#country_model_title').append('Create Country');
        $('#country_name_ar').val('');
        $('#country_name_en').val('');

        $('#createCity').modal('toggle');
    }

    function getUserData(id,name_ar,name_en,code,country_code)
    {
        // let item = JSON.parse(user);
        city_id = id;
        $('#country_model_title').empty();
        $('#country_model_title').append('Update Country');
        
        /** 
         * add values
         * 
         * **/

         $('#country_name_ar').val(name_ar);
         $('#country_name_en').val(name_en);
         $('#code').val(code);
         $('#country_code').val(country_code);

        $('#createCity').modal('toggle');


    }
    function getRegionsAccordingToCountry(id)
    {
        $('#region_selecter').prop("disabled", true); 

        let url = '{{ route("dashboard.regions.index",":id") }}';
        let updateUrl = url.replace(':id',id);
        $.ajax({
            type:'GET',
            url:updateUrl,
            success:(res)=>{
                console.log('response: ',res.data);
              //  $('#city_selecter').
                $('#region_selecter').prop("disabled", false); 
                for(let i = 0; i < res.data.length;i++)
                {
                    $('#region_selecter').append(`
                        <option value='${res.data[i].id}' class="form-control">${res.data[i].name}</option>
                    `);
                }
            },
            error:(err)=>{
                Toast.fire({
                    icon: 'error',
                    title: 'Error updateing getting regions'
                })
                console.log('error getting the regions: ',err);
            }
        })
    }

    function addAreaApi()
    {
        if(!addAreaValdation()) return;
        let url = '{{route("dashboard.countries.store")}}';
        if(city_id)
        {
            let updateWithId = '{{route("dashboard.countries.update",":id")}}'
            url = updateWithId.replace(':id',city_id);
        }
        $.ajax({
            url:url,
            type:'POST',
            data:{
                name_ar:document.getElementById('country_name_ar').value,
                name_en:document.getElementById('country_name_en').value,
                code:document.getElementById('code').value,
                country_code:document.getElementById('country_code').value,
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
        if(document.getElementById('country_name_ar').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add country name in arabic'
            })
            return false;
        }
        if(document.getElementById('country_name_en').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add country name in English'
            })
            return false;
        }
        if(document.getElementById('code').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add country phone code'
            })
            return false;
        }
        if(document.getElementById('country_code').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add country code'
            })
            return false;
        }
        return true;

    }

</script>

@endsection
