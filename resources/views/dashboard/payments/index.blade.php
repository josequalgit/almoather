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
                            <li class="breadcrumb-item active">Payment
                            </li>
                        </ol>
                        
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
                                <h4 class="card-title">Payment's</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                             
                                <div class="table-responsive">
                                    @can('See Faq')
                                    <table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                               
                                                <th>
                                                    <span class="align-middle">Invoice#</span>
                                                </th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                              
                                                <td>
                                                    <a href="{{ route('dashboard.payments.details',$item->id) }}">#{{ $item }}</a>
                                                </td>
                                                <td><span class="invoice-amount">${{ $item->amount }}</span></td>
                                                <td><small class="text-muted">{{ $item->created_at->format('d-m-y') }}</small></td>
                                                <td><span class="invoice-customer">{{ $item->ads->customers->full_name }}</span></td>
                                              
                                                <td><span class="badge badge-light-{{ $item->status_code == '000'?'success':'danger'}} badge-pill">{{ $item->status_code }}</span></td>
                                              
                                            </tr>
                                                
                                            @endforeach
                                         
                                        </tbody>
                                    </table>
                                    @endcan
                                </div>
                            </div>
                            {{-- @can('See Faq')
                            {{ $data->links() }}
                            @endcan --}}
                            @can('See Faq')
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
    <div id="faqModel" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Faq!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="faqName"></span>' faq ?</p>
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
    let role_id = null;

    function openModal(id,name)
    {
        role_id = id;
        $('#faqName').empty();
        $('#faqName').append(name);
        $('#faqModel').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.faqs.delete",":id") }}';
        let updatedUrl = url.replace(':id',role_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                if(!res.err)
                {
                    location.reload();
                }
              
            },
            error:(err)=>{
                console.log('delete faq Error')
            }
        });
    }
</script>

@endsection
