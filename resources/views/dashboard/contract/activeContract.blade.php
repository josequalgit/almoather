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
                                    @can('See Faq')
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Influncer</th>
                                                    <th>Contract view</th>
                                                    <th>Ad</th>
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
                                                            <td>{{ $item->influencers->full_name }}</td>
                                                            <td>{{ $item->content }}</td>
                                                            <td>{{ $item->ads->store }}</td>
                                                            <td>{{ $item->ads->customers->first_name  }} {{ $item->ads->customers->last_name }}</td>
                                                            <td>{{ $item->date  }}</td>
                                                            <td>{{ $item->created_at  }}</td>
                                                            <td>
                                                                <button onclick="openModal({{$item->id}})" class="btn btn-secondary">
                                                                    <i class="bx bx-show"></i>
                                                                </button>
                                                            </td>
                                                        
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endcan
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
              {{-- <p>Are you sure you want to delete this  '<span id="faqName"></span>' faq ?</p> --}}
              <p>Ad Link <br/><span id="faqName"></span></p>

              <label for="">Note</label>
              <textarea id="note" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
              <button onclick="changeStatus(1)" type="button" class="btn btn-primary">Accept</button>
              <button onclick="changeStatus()"type="button" class="btn btn-secondary" data-dismiss="modal">Reject</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')

<script>
    let contract_id = null;

    function openModal(id,link)
    {
        contract_id = id;
        
        $('#faqName').empty();
        $('#faqName').append(link);
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
                "note":document.getElementById('note').value
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
</script>

@endsection
