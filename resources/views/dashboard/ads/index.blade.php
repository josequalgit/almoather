@extends('dashboard.layout.index')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">

            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Categories</p>
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
                <div class="card-body campaign-items">
                    <div class="row grid-items" style="{{ !isset($_COOKIE['data-item']) || $_COOKIE['data-item'] == 'grid-items' ? '' : 'display: none'}}">
                        @foreach ($data as $item)
                        <div class="col-md-4 col-xl-3 mb-2">
                            <div class="item-wrapper">
                                <div class="list-item profile-block">

                                    <div class="block-top">
                                        <div class="dropdown more">
                                            <button class="styleless-button" data-toggle="dropdown"><i class="bx bx-menu"></i>
                                            <span class="caret"></span></button>

                                            <ul class="dropdown-menu border menu-position m-0 p-1">
                                                    <li  class="list-item-custom">
                                                        
                                                        <button class="styleless-button w-100 text-left p-0" onclick="openModalSeeContract('{{ $item->contacts?$item->contacts->content:'No data avalibale' }}')">
                                                            <i class="bx bx-printer list-item-icon"></i>
                                                            <span class="list-item-text">Print</span>
                                                        </button>
                                                </li>

                                                    <li  class="list-item-custom">
                                                        <button class="styleless-button w-100 text-left p-0" onclick="seeMatched('{{$item->id}}')">
                                                            <i class="bx bx-user list-item-icon"></i>
                                                            <span class="list-item-text">Influncers</span>
                                                        </button>
                                                </li>

                                                <li  class="list-item-custom">
                                                    <a class="styleless-button w-100 text-left p-0" href="{{ route("dashboard.ads.edit",$item->id) }}" >
                                                        <i class="bx bx-book-content list-item-icon"></i>
                                                        <span class="list-item-text">Details</span>
                                                    </a>
                                                </li>

                                                <li  class="list-item-custom">
                                                    <a class="styleless-button w-100 text-left p-0" href="{{ route("dashboard.ads.update_info_view",$item->id) }}" >
                                                        <i class="bx bx-edit list-item-icon"></i>
                                                        <span class="list-item-text">Edit</span>
                                                    </a>
                                                </li>

                                            </ul>
                                          </div>
                                        <div class="back-grey"></div>
                                        <div class="block-image"><img src="{{ $item->logo['url']  }}" alt="{{ $item->store }}"></div>

                                    </div>
                                    <div class="block-info">
                                        <span class="name">{{ $item->store }}</span>
                                        <small class="campaign-date">{{ $item->created_at->diffForHumans() }}</small>
                                        @if($item->categories)
                                        <div class="categories text-center">
                                            @foreach($item->categories()->pluck('name')->toArray() as $cat)
                                            <span class="desc badge bg-info mt-1">{{$cat}}</span>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="desc badge bg-info mt-1">No category choosen</span>
                                        @endif
                                    </div>
                                    <div class="block-counts w-100 pt-2 row">
                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span><i class="fas fa-dollar-sign"></i> Budget</span>
                                                <span class="numbers">{{ number_format($item->budget); }}</span>

                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span><i class="fas fa-bullseye"></i> Goal</span>
                                                <span class="numbers">{{ $item->campaignGoals->title; }}</span>
                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span><i class="fas fa-audio-description"></i> Type</span>
                                                <span class="numbers">{{ $item->type ? $item->type : 'Not selected yet' }}</span>

                                            </div>
                                        </div>

                                        <div class="followers text-center col-12 mb-1">
                                            <div class="count-box">
                                                <span><i class="fas fa-plane-slash"></i> Campaign Type</span>
                                                <span class="numbers">{{ ucwords(str_replace('_',' ',$item->ad_type)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-add w-100 text-center">
                                        <span class="campaign-status badge bg-warning my-1">{{ $item->status }}</span>
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Budget</th>
                                    <th>Goal</th>
                                    <th>Type</th>
                                    <th>Campaign Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                        <tr>
                                            <td><img src="{{ $item->logo['url']  }}" alt="{{ $item->store }}" alt="{{ $item->store }}"></td>
                                            <td>{{ $item->store }}</td>
                                            <td>
                                                @if($item->categories)
                                                <div class="categories text-center">
                                                    @foreach($item->categories()->pluck('name')->toArray() as $cat)
                                                    <span class="desc badge bg-info mt-1 d-block">{{$cat}}</span>
                                                    @endforeach
                                                </div>
                                                @else
                                                <span class="desc badge bg-info mt-1">No category choosen</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->budget); }}</td>
                                            <td>{{ $item->campaignGoals->title; }}</td>
                                            <td>{{ $item->type ? $item->type : 'Not selected yet' }}</td>
                                            <td>{{ ucwords(str_replace('_',' ',$item->ad_type)) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                            <td>
                                                <button class="btn btn-secondary btn-sm mb-1" onclick="openModalSeeContract('{{ $item->contacts?$item->contacts->content:'No data avalibale' }}')">
                                                    <i class="bx bx-printer list-item-icon"></i>
                                                </button>

                                                <button class="btn btn-secondary btn-sm mb-1" onclick="seeMatched('{{$item->id}}')">
                                                    <i class="bx bx-user list-item-icon"></i>
                                                </button>
                                                <a class="btn btn-secondary btn-sm" href="{{ route("dashboard.ads.edit",$item->id) }}" >
                                                    <i class="bx bx-book-content list-item-icon"></i>
                                                </a>
                                                <a class="btn btn-secondary btn-sm" href="{{ route("dashboard.ads.edit",$item->id) }}" >
                                                    <i class="bx bx-book-content list-item-icon"></i>
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
            <!-- Basic tabs start -->
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
