@extends('dashboard.layout.index')

@section('content')
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
                            <li class="breadcrumb-item active">Customers
                            </li>
                        </ol>
                        {{-- @can('Create Influncer')
                            <a href="{{ route('dashboard.customers.create') }}" class=" btn btn-primary float-right">Create</a>                            
                        @endcan --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body mt-5">
            <!-- Basic tabs start -->
            @can('See Customer')
            <div class="col">
                <div class="card widget-followers">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Customers</h4>
                            <small class="text-muted">this is the amount of customers added every month</small>
                        </div>
                        <div class="d-flex align-items-center widget-followers-heading-right">
                            <h5 class="mr-2 font-weight-normal mb-0">{{ $counter }}</h5>
                            {{-- <div class="d-flex flex-column align-items-center">
                                <i class='bx bx-caret-up text-success font-medium-1'></i>
                                <small class="text-muted">+31%</small>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="follower-primary-chart"></div>
                    </div>
                </div>
            </div>
            @endcan
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Customers</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                @can('See Customer')
                                 <p class="card-text">
                                    There is {{ $counter }} Customer/'s
                                </p>
                                @endcan
                                <div class="table-responsive">
                                    @can('See Customer')
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->full_name }}</td>
                                                        <td>{{ $item->users->email }}</td>
                                                        <td>{{ $item->phone }}</td>
                                                        <td style="text-transform: uppercase;">{{ $item->status }}</td>
                                                        <td>
                                                           @can('Edit Customer')
                                                            <a class="btn btn-secondary" href="{{ route('dashboard.customers.edit',$item->id) }}">
                                                                <i class="bx bx-show"></i>
                                                            </a>                                                               
                                                           @endcan
                                                           @can('See Customer Ads')
                                                            <a class="btn btn-secondary" href="{{ route('dashboard.customers.showAds',$item->id) }}">
                                                                <i class="bx bx-broadcast"></i>
                                                            </a>                                                               
                                                           @endcan
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Customer')
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
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Customers!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="adminInfluncerModal"></span>' ?</p>
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
    let admin_id = null;

    function openModal(id,name)
    {
        admin_id = id;
        $('#adminInfluncerModal').empty();
        $('#adminInfluncerModal').append(name);
        $('#deleteModal').modal('toggle');
    };

    function deleteApi()
    {
        let url = '{{ route("dashboard.admins.delete",":id") }}';
        let updatedUrl = url.replace(':id',admin_id);
        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{
                location.reload();
            },
            error:(err)=>{
                console.log('delete admin Error')
            }
        });
    }
    var options = {
          series: [{
            name: "Influncers",
            data: {{json_encode($influncersData)}}
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Registration data ',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Des'],
        },
        
        };

        var chart = new ApexCharts(document.querySelector("#follower-primary-chart"), options);
        chart.render();
</script>

@endsection
