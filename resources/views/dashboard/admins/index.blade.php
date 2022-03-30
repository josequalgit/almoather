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
                            <li class="breadcrumb-item active">Admins
                            </li>
                        </ol>
                        @can('Create Admin')
                            <a href="{{ route('dashboard.admins.create') }}" class=" btn btn-primary float-right">Create</a>                            
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-body mt-5 container-xxl flex-grow-1 container-p-y">
            {{-- <div class="col">
                <div class="card widget-followers">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Users</h4>
                            <small class="text-muted">Admins</small>
                        </div>
                        <div class="d-flex align-items-center widget-followers-heading-right">
                            <h5 class="mr-2 font-weight-normal mb-0">520K</h5>
                            <div class="d-flex flex-column align-items-center">
                                <i class='bx bx-caret-up text-success font-medium-1'></i>
                                <small class="text-muted">+31%</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="follower-primary-chart"></div>
                    </div>
                </div>
            </div> --}}
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Admins</h4>
                            </div>
                            
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}
                                <div class="table-responsive">
                                    @can('See Admin')
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->roles[0]->name }}</td>
                                                        <td>
                                                           @can('Edit Admin')
                                                            <a class="btn btn-secondary" href="{{ route('dashboard.admins.edit',$item->id) }}">
                                                                <i class="bx bx-edit"></i>
                                                            </a>                                                               
                                                           @endcan
                                                            @can('Delete Admin')
                                                                <button class="btn btn-danger"  onclick="openModal('{{ $item->id }}','{{ $item->name }}')">
                                                                    <i class="bx bx-trash deleteIcon"></i>
                                                                </button>                                                                
                                                            @endcan
                                                           
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endcan
                                </div>
                            </div>
                            @can('See Admin')
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
              <h5 class="modal-title">Delete Admin!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this  '<span id="adminNameModal"></span>' ?</p>
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
        $('#adminNameModal').empty();
        $('#adminNameModal').append(name);
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
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
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
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#follower-primary-chart"), options);
        chart.render();
</script>

@endsection