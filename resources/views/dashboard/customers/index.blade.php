@extends('dashboard.layout.index')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="card-title">
                                <p class="mb-0">Customers</p>
                                <small class="text-muted">{{ $counter }} Customers Found</small>
                            </div>
                            <hr class="w-100">
                        </div>
                        <div class="card-body card-dashboard">
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
                                                    <td>{{ $item->first_name }} {{ $item->middle_name }}
                                                        {{ $item->last_name }}</td>
                                                    <td>{{ $item->users->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td style="text-transform: uppercase;">{{ $item->status }}</td>
                                                    <td>
                                                        @can('Edit Customer')
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('dashboard.customers.edit', $item->id) }}">
                                                                <i class="bx bx-show"></i>
                                                            </a>
                                                        @endcan
                                                        @can('See Customer Ads')
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('dashboard.customers.showAds', $item->id) }}">
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
                </section>
                @can('See Customer')
                <div class="card widget-followers">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="mb-0">Customers</p>
                            <small class="text-muted">this is the amount of customers added every month</small>
                        </div>
                        <hr class="w-100">
                    </div>
                    <div class="card-body">
                        <div id="follower-primary-chart"></div>
                    </div>
                </div>
            @endcan
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
                        <p>Are you sure you want to delete this '<span id="adminInfluncerModal"></span>' ?</p>
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

        function openModal(id, name) {
            admin_id = id;
            $('#adminInfluncerModal').empty();
            $('#adminInfluncerModal').append(name);
            $('#deleteModal').modal('toggle');
        };

        function deleteApi() {
            let url = '{{ route('dashboard.admins.delete', ':id') }}';
            let updatedUrl = url.replace(':id', admin_id);
            $.ajax({
                type: 'GET',
                url: updatedUrl,
                success: (res) => {
                    location.reload();
                },
                error: (err) => {
                    console.log('delete admin Error')
                }
            });
        }
        var options = {
            series: [{
                name: "Influncers",
                data: {{ json_encode($influncersData) }}
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
            },

        };

        var chart = new ApexCharts(document.querySelector("#follower-primary-chart"), options);
        chart.render();
    </script>
@endsection
