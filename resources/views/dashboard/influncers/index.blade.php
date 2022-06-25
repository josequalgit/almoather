@extends('dashboard.layout.index')

@section('content')
<div class="app-content content">
    
    <div class="content-wrapper">
        <div class="content-body">
            
            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">{{ ucwords($status) }} Influencer</p>   
                        <small class="text-muted mb-0">{{ $counter}} Influncers Found</small>
                    </div>
                    
                    <div class="section-right">
                        <ul class="view-type d-flex list-unstyled">
                            <li><div class="search-item"><input type="search" class="form-control" value="" placeholder="Search"><i class="bx bx-search"></i></div></li>
                            <li class=""><a href="#" class="grid {{ !isset($_COOKIE['data-item']) || $_COOKIE['data-item'] == 'grid-items' ? 'active' : ''}}" data-item="grid-items"><i class="bx bx-grid-alt"></i></a></li>
                            <li class=""><a href="#" class="list {{ isset($_COOKIE['data-item']) && $_COOKIE['data-item'] == 'list-items' ? 'active' : ''}}" data-item="list-items"><i class="bx bx-list-ul"></i></a></li>
                        </ul>
                    </div>
                    <hr class="w-100">
                </div>
                <div class="card-body">
                    <div class="row grid-items"  style="{{ !isset($_COOKIE['data-item']) || $_COOKIE['data-item'] == 'grid-items' ? '' : 'display: none'}}">
                        @foreach ($data as $item)
                        <div class="col-md-4 col-xl-3 mb-2">
                            <div class="item-wrapper">
                                <div class="list-item profile-block">
                                    <div class="block-top">
                                        <div class="flag"><img src="https://ipdata.co/flags/{{ strtolower($item->countries->code) }}.png" alt="{{$item->countries->name}}"></div>
                                        <div class="back-grey"></div>
                                        <div class="block-image"><img src="{{ $item->users->image['url'] }}" alt="{{ $item->full_name }}"></div>
                                    </div>
                                    <div class="block-info mw-100">
                                        <span class="name">{{ $item->full_name }}</span>
                                        <div class="categories mw-100 text-center">
                                            @foreach($item->InfluncerCategories()->pluck('name')->toArray() as $cat)
                                            <span class="desc badge mw-100 bg-info mt-1">{{$cat}}</span>
                                            @endforeach
                                        </div>
                                    
                                    </div>
                                    <div class="block-counts w-100 py-2 row">
                                        <div class="followers text-center col-6 mb-1">
                                            <div class="count-box">
                                                <span class="numbers">{{ number_format($item->subscribers); }}</span>
                                                <span>Followers</span>
                                            </div>
                                        </div>
                                        <div class="engagement text-center col-6 mb-1">
                                            <div class="count-box">
                                                <span class="numbers">{{ $item->engRate }}%</span>
                                                <span>Engagement</span>
                                            </div>
                                        </div>
                                        <div class="engagement text-center col-6 mb-1">
                                            <div class="count-box">
                                                <span class="numbers">{{ number_format($item->ROAS) }}</span>
                                                <span>ROAS</span>
                                            </div>
                                        </div>
                                        <div class="engagement text-center col-6 mb-1">
                                            <div class="count-box">
                                                <span class="numbers">{{ number_format($item->AOAF) }}</span>
                                                <span>AOAF</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-add w-100">
                                        <a href="{{ route('dashboard.influncers.edit',$item->id) }}" class="btn">View <i class="bx bx-edit"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                    <div class="row list-items" style="{{ isset($_COOKIE['data-item']) && $_COOKIE['data-item'] == 'list-items' ? '' : 'display: none'}}">
                        <table class="table zero-configuration table-influencers col-12" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>Followers</th>
                                    <th>Engagement</th>
                                    <th>AOAF</th>
                                    <th>ROAS</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                        <tr>
                                            <td><img src="{{ $item->users->image['url'] }}" alt="{{ $item->full_name }}"></td>
                                            <td>{{ $item->full_name  }}</td>
                                            <td><div class="d-flex justify-content-center align-items-center"><div class="contry-name">{{$item->countries->name}}</div> <div class="flag"><img src="https://ipdata.co/flags/{{ strtolower($item->countries->code) }}.png" alt="{{$item->countries->name}}"></div></div></td>
                                            <td>{{ $item->subscribers }}</td>
                                            <td>{{ $item->engRate }}%</td>
                                            <td>{{ number_format($item->AOAF) }}</td>
                                            <td>{{ number_format($item->ROAS) }}</td>
                                            <td>
                                                <a class="btn btn-secondary" href="{{ route('dashboard.influncers.edit',$item->id) }}">
                                                    <i class="bx bx-show"></i>
                                                </a>    
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        
                    <div class="mt-1 pagination-wrapper">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card widget-followers">
                        <div class="card-header pb-0">
                            <div class="card-title">
                                <p class="mb-0">Influencer</p>   
                                <small class="text-muted mb-0">Number of influncers registred every month</small>
                            </div>
                            <hr class="w-100">
                        </div>
                        
                        <div class="card-body">
                            <div id="follower-primary-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card widget-followers">
                        <div class="card-header pb-0">
                            <div class="card-title">
                                <p class="mb-0">Top Influencer</p>   
                                <small class="text-muted mb-0">Top Influencers (Completed ADS)</small>
                            </div>
                            <hr class="w-100">
                        </div>
                        
                        <div class="card-body">
                            <div id="ads-chart"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Influncer!</h5>
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
            data: {{json_encode($influencerData)}}
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

        var options = {
          series: [{
          data: [50, 16]
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: [
            ['Sephea', 'asd'],
            ['Sephea', 'asd']
          ],
          labels: {
            style: { 
              fontSize: '12px'
            }
          }
        }
        };

        var adsChart = new ApexCharts(document.querySelector("#ads-chart"), options);
        adsChart.render();

        $('.view-type a').on('click',function(e){
            e.preventDefault();
            let item = $(this).attr('data-item');
            $('.view-type a').removeClass('active');
            $(this).addClass('active');
            $('.'+item).show().siblings().hide();
            setCookie('data-item',item,3600);
        });
</script>

@endsection
