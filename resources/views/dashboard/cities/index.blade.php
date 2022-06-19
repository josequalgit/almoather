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
                                    <p class="mb-0">City</p>
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
                                                        <th>Region</th>
                                                        <th>Country</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            
                                                            <td>{{ $item->getTranslation('name','ar') }}</td>
                                                            <td>{{ $item->getTranslation('name','en') }}</td>
                                                            <td>{{ $item->regions->name }}</td>
                                                            <td>{{ $item->regions->countries->name }}</td>
                                                            <td>
                                                                {{-- @can('Edit City') --}}
                                                                    <button onclick="getUserData('{{ $item->id }}','{{$item->getTranslation('name','ar') }}','{{ $item->getTranslation('name','en') }}','{{ $item->regions->countries->id }}','{{ $item->regions->id }}')" class="btn btn-secondary">
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
                    <h3 id="city_model_title" class="text-center modal-title">
                        Create City
                    </h3>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name AR</label>
                        <input id="city_name_ar" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Name ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name En</label>
                        <input id="city_name_en" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Name ">
                      </div>
                      <div class="mb-1">
                        <label for="exampleFormControlTextarea1" class="form-label">Country</label>
                        <select id="country" onchange="getRegionsAccordingToCountry(event.target.value)" class="form-control" aria-label="Default select example">
                            @foreach($countries as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                          
                      </div>
                      <div class="mb-1">
                        <label for="exampleFormControlTextarea1" class="form-label">Region</label>
                        <select  placeholder="here" id="region_selecter" disabled class="form-control" aria-label="Default select example">
                        </select>
                          
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button onclick="addCityApi()" type="button" class="btn btn-primary createCityButton">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete City!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this '<span id="faqName"></span>' city ?</p>
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

    getRegionsAccordingToCountry('{{ $countries[0]->id }}')

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
        let url = '{{ route("dashboard.cities.delete",":id") }}';
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
        $('#city_model_title').empty();
        $('#city_model_title').append('Create City');
        $('#city_name_ar').val('');
         $('#city_name_en').val('');

        $('#createCity').modal('toggle');
    }

    function getUserData(id,name_ar,name_en,country_id,region_id)
    {
        // let item = JSON.parse(user);
        city_id = id;
        $('#city_model_title').empty();
        $('#city_model_title').append('Update City');
        /** 
         * add values
         * 
         * **/

         $('#city_name_ar').val(name_ar);
         $('#city_name_en').val(name_en);
         $('#country_id').val(country_id);
         $('#region_id').val(region_id);

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
                $('#region_selecter').empty();
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

    function addCityApi()
    {
        if(!addCityValdation()) return;

        let url = '{{route("dashboard.cities.store")}}';
        if(city_id)
        {
            let updateWithId = '{{route("dashboard.cities.update",":id")}}'
            url = updateWithId.replace(':id',city_id);
        }
        $.ajax({
            url:url,
            type:'POST',
            data:{
                name_ar:document.getElementById('city_name_ar').value,
                name_en:document.getElementById('city_name_en').value,
                region_id:document.getElementById('region_selecter').value,
                _token:'{{ csrf_token() }}'
            },
            success:(res)=>{
               window.location.reload();
            },
            error:(err)=>{
                Toast.fire({
                    icon: 'error',
                    title: 'Error adding the city'
                })
                console.log('err: '+err)
            }
        })
    }

    function addCityValdation()
    {
        if(document.getElementById('city_name_ar').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add city name in arabic'
            })
            return false;
        }
        if(document.getElementById('city_name_en').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please add city name in english'
            })
            return false;
        }
        if(document.getElementById('country').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please select country'
            })
            return false;
        }
        if(document.getElementById('region_selecter').value == '')
        {
            Toast.fire({
                    icon: 'error',
                    title: 'Please select region '
            })
            return false;
        }
        return true;

    }

</script>

@endsection
