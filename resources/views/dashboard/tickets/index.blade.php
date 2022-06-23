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
                                    <p class="mb-0">Tickets</p>
                                </div>

                                <div class="section-right">
                                    {{-- <button  onclick="openModalCreateCity()" class="btn btn-secondary">Create</button> --}}
                                </div>
                                <hr class="w-100 my-1">
                                <div class="w-100 card-dashboard">
                                    <div class="table-responsive">
                                        {{-- @can('See City') --}}
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Message</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td>{{ $item->message }}</td>
                                                            <td>
                                                                {{-- @can('Edit City') --}}
                                                                    <button onclick="getUserData('{{ $item->id }}','{{ $item->name }}','{{ $item->email }}','{{ $item->message }}')" class="btn btn-secondary">
                                                                        <i class="bx bx-show"></i>
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
                        Tickets
                    </h3>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input disabled id="name" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Name ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input disabled id="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="email ">
                      </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label">Message</label>
                        <textarea class="form-control" id="message" disabled name="" id="" cols="30" rows="10">
                        </textarea>
                      </div>
                     
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                    <p>Are you sure you want to delete this '<span id="ticketsName"></span>' ticket ?</p>
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
        $('#ticketsName').empty();
        $('#ticketsName').append(name);
        $('#deleteModal').modal('toggle');
    };


    function deleteApi() 
    {
        let url = '{{ route("dashboard.tickets.delete",":id") }}';
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
        $('#city_model_title').append('Show Ticket');
        $('#city_name_ar').val('');
         $('#city_name_en').val('');

        $('#createCity').modal('toggle');
    }

    function getUserData(id,name,email,message)
    {
        // let item = JSON.parse(user);
        city_id = id;
        $('#city_model_title').empty();
        $('#city_model_title').append('Show Ticket');
        /** 
         * add values
         * 
         * **/

         $('#name').val(name);
         $('#email').val(email);
         $('#message').val(message);

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
