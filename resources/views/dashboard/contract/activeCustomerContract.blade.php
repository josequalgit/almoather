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
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="breadcrumbs-top">
                    <h5 class="content-header-title float-left pr-1 mb-0">Tabs</h5>
                    <div class="breadcrumb-wrapper d-none d-sm-block">
                        <ol class="breadcrumb p-0 mb-0 pl-1">
                            <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Active Contract
                            </li>
                        </ol>
                        {{-- @can('Create Faq')
                        <a href="{{ route('dashboard.faqs.create') }}" class=" btn btn-primary float-right">Create</a>                            
                        @endcan --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body mt-5">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Active Contract</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                             
                                <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Contract view</th>
                                                    <th>Customer</th>
                                                    <th>Execute</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                        <tr>
                                                            <td>#{{ $item->id }}</td>
                                                            <td>{{ $item->content }}</td>
                                                            <td>{{ $item->customers->first_name  }} {{ $item->customers->last_name }}</td>
                                                            <td>{{ $item->date  }}</td>
                                                            <td>{{ $item->created_at  }}</td>
                                                            <td>
                                                                <button onclick="openModal({{$item->id}},'{{ $item->content }}')" class="btn btn-secondary">
                                                                    <i class="bx bx-edit"></i>
                                                                </button>
                                                                <button onclick="seeMatchedInfluncers({{$item->id}})" class="btn btn-secondary">
                                                                    <i class="bx bx-show"></i>
                                                                </button>
                                                            </td>
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                            <div class="p-1">
                                {{ $data->links('pagination::bootstrap-5') }}
                            </div>
                       
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div  id="inf" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Matched Inulncers</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" >
                      <div class="col">
                        <div class="user-dashboard-info-box table-responsive mb-0 bg-white  shadow-sm">
                          <table class="table manage-candidates-top mb-0">
                            {{-- <thead>
                              <tr>
                                <th>Candidate Name</th>
                                <th class="text-center">Status</th>
                                <th class="action text-right">Action</th>
                              </tr>
                            </thead> --}}
                            <tbody id="infList">
                              {{-- @foreach ($matches as $item) --}}
                              
                              
                              {{-- @endforeach --}}
                            </tbody>
                          </table>
                        </div>
                      </div>
              

              
            </div>
            <div class="modal-footer">
              {{-- <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button> --}}
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>



    <div id="contractContent" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Info!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="">contract</label>
              <textarea id="contractData"></textarea>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Date</label>
                <input id="contractDate" value="" name="website_link" type="date" class="form-control" id="inputAddress2" placeholder="date">
              </div>   

            </div>
            <div class="modal-footer">
              <button onclick="sendContract()" type="button" class="btn btn-primary">Send</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Reject</button>
            </div>
          </div>
        </div>
      </div>
      
</div>
@endsection

@section('scripts')

<script>
    CKEDITOR.replace('contractData', {
      extraPlugins: 'justify,placeholder,colorbutton',
      height: 600,
      removeButtons: 'PasteFromWord'
    });

    let customer_id = null;

    function openModal(id,content)
    {
        customer_id = id;
        
        $('#faqName').empty();
        // $('#faqName').append(link);
        CKEDITOR.instances['contractData'].setData(content);

        $('#contractContent').modal('toggle');
    };

    function changeStatus(status = null)
    {
        console.log(status)
        let url = '{{ route("dashboard.contracts.changeStatus",[":id",":status"]) }}';
        let updatedUrl = url.replace(':id',contract_id);
        let addedContract = updatedUrl.replace(':status',status);
        $.ajax({
            type:'POST',
            url:addedContract,
            data:{
                "_token": "{{ csrf_token() }}",
                "note":document.getElementById('note').value,
                "date":document.getElementById('contractDate').value,
            },
            success:(res)=>{
                console.log(res);
                if(!res.err)
                {
                    location.reload();
                }
              
            },
            error:(err)=>{
                console.log('err')
            }
        });
    }

    function sendContract(contract_id,)
  {
      if(valdation()) return alert(valdation())
    let url = '{{ route("dashboard.ads.sendContractToCustomer",":id") }}';
    let addId = url.replace(':id',customer_id);
    $.ajax({
      url:addId,
      data:{
        // customer_id:choosen_inf_id,
        '_token':'{{csrf_token()}}',
        content:CKEDITOR.instances['contractData'].getData(),
        date:document.getElementById('contractDate').value
      },
      
      type:'POST',
      success:(res)=>{
        document.getElementById('contractContent').value = '';
        console.log('success: ',res);
        $('#seeContract').modal('toggle');
      },
      error:(err)=>{
        console.log('error: ',err);
      }
    })
    
  }

  function valdation()
  {
    if(CKEDITOR.instances['contractData'].getData() == '')
      {
          return 'content is required'
      }
      if(document.getElementById('contractDate').value == '')
      {
          return 'date is required'
      }
      return false
  }

  function seeMatchedInfluncers(contract_id)
  {

 let url = '{{ route("dashboard.ads.seeContractInfluencer",":id") }}';
    let addId = url.replace(':id',contract_id);
    $.ajax({
      url:addId,
      type:'GET',
      success:(res)=>{

        for (let index = 0; index < res.influncers.length; index++) {
            const element = res.influncers[index];
                let div = `
                    <tr class="candidates-list bg-dnager">
                            <td class="title">
                                <div class="thumb">
                                <img class="img-fluid" src="${element.image}" alt="">
                                </div>
                                <div class="candidate-list-details">
                                    <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                            <h5 class="mb-0">${element.name}</h5>
                                            <span style="font-size:12px;">${element.match}%</span><br/>
                                        </div>
                                    </div>
                                </div>
                            </td>
                    </tr>
                `;
                $('#infList').append(div);

        }
        $('#inf').modal('toggle');
      },
      error:(err)=>{
        console.log('error: ',err);
      }
    })

   
  }

</script>

@endsection
