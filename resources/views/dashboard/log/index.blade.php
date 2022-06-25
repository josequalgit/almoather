@extends('dashboard.layout.index')

@section('content')

<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Logs</h4>
                            </div>
                            <div class="card-body card-dashboard">
                                {{-- <p class="card-text">
                                    There is 40 doctor added
                                </p> --}}

                                <div class="table-responsive">
                                    @can('See Logs')

                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>User</th>
                                                <th>Was made</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->description }}</td>
                                                        <td>{{  $item->causer ? $item->causer?->name : 'Guest'}}</td>
                                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endcan

                                </div>
                            </div>

                            @can('See Logs')
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
</div>
@endsection
