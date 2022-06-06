@extends('dashboard.layout.index')

@section('content')

<style>
    .user-dashboard-info-box .candidates-list .thumb {
    margin-right: 20px;
}
.user-dashboard-info-box .candidates-list .thumb img {
    width: 80px;
    height: 80px;
    -o-object-fit: cover;
    object-fit: cover;
    overflow: hidden;
    border-radius: 50%;
}

.user-dashboard-info-box .title {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 30px 0;
}

.user-dashboard-info-box .candidates-list td {
    vertical-align: middle;
}

.user-dashboard-info-box td li {
    margin: 0 4px;
}

.user-dashboard-info-box .table thead th {
    border-bottom: none;
}

.table.manage-candidates-top th {
    border: 0;
}

.user-dashboard-info-box .candidate-list-favourite-time .candidate-list-favourite {
    margin-bottom: 10px;
}

.table.manage-candidates-top {
    /* min-width: 650px; */
}

.user-dashboard-info-box .candidate-list-details ul {
    color: #969696;
}

/* Candidate List */
.candidate-list {
    background: #ffffff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    border-bottom: 1px solid #eeeeee;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 20px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.candidate-list:hover {
    -webkit-box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
    box-shadow: 0px 0px 34px 4px rgba(33, 37, 41, 0.06);
    position: relative;
    z-index: 99;
}
.candidate-list:hover a.candidate-list-favourite {
    color: #e74c3c;
    -webkit-box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1);
    box-shadow: -1px 4px 10px 1px rgba(24, 111, 201, 0.1);
}

.candidate-list .candidate-list-image {
    margin-right: 25px;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 80px;
    flex: 0 0 80px;
    border: none;
}
.candidate-list .candidate-list-image img {
    width: 80px;
    height: 80px;
    -o-object-fit: cover;
    object-fit: cover;
}

.candidate-list-title {
    margin-bottom: 5px;
}

.candidate-list-details ul {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-bottom: 0px;
}
.candidate-list-details ul li {
    margin: 5px 10px 5px 0px;
    font-size: 13px;
}

.candidate-list .candidate-list-favourite-time {
    margin-left: auto;
    text-align: center;
    font-size: 13px;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 90px;
    flex: 0 0 90px;
}
.candidate-list .candidate-list-favourite-time span {
    display: block;
    margin: 0 auto;
}
.candidate-list .candidate-list-favourite-time .candidate-list-favourite {
    display: inline-block;
    position: relative;
    height: 40px;
    width: 40px;
    line-height: 40px;
    border: 1px solid #eeeeee;
    border-radius: 100%;
    text-align: center;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    margin-bottom: 20px;
    font-size: 16px;
    color: #646f79;
}
.candidate-list .candidate-list-favourite-time .candidate-list-favourite:hover {
    background: #ffffff;
    color: #e74c3c;
}

.candidate-banner .candidate-list:hover {
    position: inherit;
    -webkit-box-shadow: inherit;
    box-shadow: inherit;
    z-index: inherit;
}

.bg-white {
    background-color: #ffffff !important;
}
.p-4 {
    padding: 1.5rem!important;
}
.mb-0, .my-0 {
    margin-bottom: 0!important;
}
.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

.user-dashboard-info-box .candidates-list .thumb {
    margin-right: 20px;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
@php
$checkStatus = array_key_exists("status", request()->route()->parameters);
$route = Route::current();
$name = $route->getName();
$para = $checkStatus ? request()->route()->parameters['status'] : null;
@endphp
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
   
        <div class="content-body mt-5">

            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Ads</p>   
                        <small class="text-muted mb-0">{{ $counter}} Ads Found</small>
                    </div>
                   
                    
                    <div class="section-right">
                        <ul class="view-type d-flex list-unstyled">
                            <li><div class="search-item"><input type="search" class="form-control" value="" placeholder="Search"><i class="bx bx-search"></i></div></li>
                            <li class=""><a href="#" class="grid {{ !isset($_COOKIE['data-item']) || $_COOKIE['data-item'] == 'grid-items' ? 'active' : ''}}" data-item="grid-items"><i class="bx bx-grid-alt"></i></a></li>
                            {{-- <li class=""><a href="#" class="list {{ isset($_COOKIE['data-item']) && $_COOKIE['data-item'] == 'list-items' ? 'active' : ''}}" data-item="list-items"><i class="bx bx-list-ul"></i></a></li> --}}
                        </ul>
                    </div>
                    <hr class="w-100">
                </div>
                <div class="card-body campaign-items">
                   
                    <div class="row grid-items"  xxstyle="{{ !isset($_COOKIE['data-item']) || $_COOKIE['data-item'] == 'grid-items' ? '' : 'display: none'}}">
                        @foreach ($takeData as $item)
                        <div class="mb-2 col-md-4 col-xl-3">
                            <div class="item-wrapper">
                                <div class="list-item profile-block">
                                    <div class="block-top">
                                        <div class="back-grey"></div>
                                        <div class="block-image"><img src="{{ $item->logo['url']  }}" alt="{{ $item->store }}"></div>
                                    </div>
                                    <div class="block-info">
                                        <span class="name">{{ $item->store }}</span>
                                        <div class="categories text-center">
                                        
                                        </div>
                                    
                                    </div>
                                    <div class="block-counts w-100 py-2 row">
                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span>Budget</span>
                                                <span class="numbers">{{ number_format($item->budget); }}</span>
                                                
                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span>Goal</span>
                                                <span class="numbers">{{ $item->campaignGoals->title; }}</span>
                                                
                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span>Category</span>
                                                <span class="numbers">{{ '' }}</span>
                                                
                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span>Type</span>
                                                <span class="numbers">{{ '' }}</span>
                                                
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
                    <div class="row list-items mt-2" style="{{ isset($_COOKIE['data-item']) && $_COOKIE['data-item'] == 'list-items' ? '' : 'display: none'}}">
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
                                            <td><img src="{{ $item->customers?$item->customers->users->image['url']:null }}" alt="{{ $item->customers->full_name }}"></td>
                                            <td>{{ $item->customers->full_name  }}</td>
                                            <td><div class="d-flex justify-content-center align-items-center"><div class="contry-name">{{$item->countries->name}}</div> <div class="flag"><img src="https://ipdata.co/flags/{{ strtolower($item->countries->country_code) }}.png" alt="{{$item->countries->name}}"></div></div></td>
                                            <td>100,000</td>
                                            <td>87%</td>
                                            <td>77%</td>
                                            <td>55,000</td>
                                            <td>
                                                <a class="btn btn-secondary" href="{{ route('dashboard.ads.edit',$item->id) }}">
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

    <div id="seeMatched" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">See Matched!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
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
                        <tbody id="matchedTabel">
                         
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

       <div id="seeContract" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Contract</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p id="contractContent">

                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary text-center align-middle" onclick="printContract()">
                    <i class="bx bx-printer"></i>
                </button>
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

    function openModalSeeContract(content)
    {
        $('#contractContent').empty();
        $('#contractContent').append(content)
        $('#seeContract').modal('toggle');
    }

    function printContract()
    {
        var divContents = document.getElementById("contractContent").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Contract<br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
    }
    

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

    function seeMatched(ad_id)
    {
        let url = '{{ route("dashboard.ads.seeMatched",":id") }}';
        let updatedUrl = url.replace(':id',ad_id);

        $.ajax({
            type:'GET',
            url:updatedUrl,
            success:(res)=>{

                if(res.status == 200)
                {
                    $('#matchedTabel').empty();

                    for (let index = 0; index < res.data.length; index++) {
                        const element = res.data[index];
                            console.log(element)
                       let div = `<tr class="candidates-list bg-dnager">
                            <td class="title">
                              <div class="thumb">
                                <img class="img-fluid" src="${element.image}" alt="">
                              </div>
                              <div class="candidate-list-details">
                                <div class="candidate-list-info">
                                  <div class="candidate-list-title">
                                    <h5 class="mb-0">${element.name}</h5>
                                    <span style="font-size:12px;">${element.match}%</span><br/>
                                    {{-- <a href="#" class="text-info float-right" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a> --}}
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        `

                        $('#matchedTabel').append(div);
                    }
                    $('#seeMatched').modal('toggle');

                }
                else
                {
                  return alert('some thing wrong');
                }
                
                // location.reload();

            },
            error:(err)=>{
                console.log('delete admin Error')
            }
        });
    }
</script>

@endsection
