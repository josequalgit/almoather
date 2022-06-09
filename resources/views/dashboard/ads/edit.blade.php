  @extends('dashboard.layout.index')
@section('content')
<link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
<link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">

<div class="app-content content">
    
    <section id="basic-input" class="content-wrapper">

            <div class="card">
                <div class="card-header pb-0">
                  <div class="card-title">
                      <p class="mb-0">Ad Details</p>   
                  </div>
                  <hr class="w-100 mt-1">
              </div>
                
                <div class="card-body">
                    <form id="ad_details_from" action="/" class="campaign-form">
                        <div class="row">
                          @if($data->status == 'pending')
                            <div id="wizard-basic">
                                <h3>CAMPAIGN</h3>
                                <section>
                                  <div class="camp-section">
                                    <div class="add-section"><h3 class="f-16 ad-title" style="">Campaign Details ({{ $data->store }})</h3>
                                                                          <div class="blocks-list">
                                                                              <div class="w-100  justify-content-center">
                                                                                  <div class="details-banner ad-details">
                                                                                          <div class="row">
                                                                                             <div class="col-lg-2 col-md-3 text-center w-100">
                                                                                                  <img class="ad-image" src="{{ $data->customers->users->image['url'] }}" alt="Ahmed ahmed jo">
                                                                                                  <h3 class="title mt-2">{{ $data->customers->full_name }}</h3>
                                                                                              </div>
                                                                                              <div class="col details-content">
                                                                                                  <p>
                                                                                                      <b class="me-2">Name:</b> {{ $data->store }}
                                                                                                  </p><div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Description:</b> <span class="me-2">{{ $data->about }}</span>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="mr-2">Category:</b>
                                                                                                      @if($data->categories)
                                                                                                      
                                                                                                        <span class="tag mr-2 category-item">{{$data->categories->name }}</span>
                                                                                                        @else
                                                                                                        <span class="tag mr-2 category-item">No Category</span>
                                                                                                      @endif
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Cr Number : {{ $data->cr_num }}</b>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">is vat: {{ $data->is_vat?'Yes':'No' }}</b>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">assoiate to ad: {{ $data->relation }} </b>
                                                                                                    </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">goal:</b> <span class="me-2">{{ $data->campaignGoals->title }}</span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">On: </b> <span class="me-2">
                                                                                                          @foreach ($data->socialMedias as $item) 
                                                                                                              <img src="{{ $item->image }}" class="rounded-circle social-media-icon" />
                                                                                                          @endforeach
                                                                                                      </span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Link: <a target="_blank" href="{{ $data->store_link }}">Click Me!</a> </b><span class="me-2">
                                                                                                      </span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Status: {{$data->status}} </b><span class="me-2">
                                                                                                      </span>
                                                                                                  </div>
                                                                                              </div>
                                                                                      </div>
                                                                                      <div class="">
                                                                                        <div class="container">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-6 col-md-12 p-2">
                                                                                                    <div class="count-box list">
                                                                                                        <span> <i class="bx bx-money"></i> Total Budget:</span>
                                                                                                        <span class="numbers">{{ $data->budget }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6 col-md-12 p-2">
                                                                                                    <div class="count-box list">
                                                                                                        <span> <i class="bx bx-user"></i> Influncer:</span>
                                                                                                        <span class="numbers">{{ count($matches) }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                  </div>
                                                                              </div>
                                                                             
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="w-100 d-flex justify-content-center">
                                                                    {{-- <button role="wizard-basic" type="button" class="btn btn-info w-50">
                                                                      Next
                                                                    </button> --}}
                                                                  </div>
                                </section>
                                <h3>CONTENT</h3>
                                <section>
                                    <div class="add-section contentSection">
                                        <div class="box-border">
                                            <div class="top-section">
                                                <div class="selected-items row">
                                                  
                                                </div>
                                            </div>
                                            <div class="main-section d-flex justify-content-center p-2">
                                              <div class="card col">
                                                <form>
                                                  <div class="col p-4">
                                                    <div >
                                                      <h6 for="add_category">Add Influncers Requarment</h6>
                                                      <div class="row p-4 add_space">
                                                        <div class="col">
                                                          <label for="">Type</label>
                                                          <select class="form-control" id="ad_type">
                                                            <option {{ $data->type == 'product'?'selected':''}} value="product">Product</option>
                                                            <option {{ $data->type == 'service'?'selected':'' }} value="service">Service</option>
                                                          </select>
                                                        </div>
                                                        <div class="col">
                                                          <label for="">Category</label>
                                                          <select class="form-control" id="ad_type">
                                                            @foreach ($categories as $item)
                                                          
                                                              <option {{ $data->category_id == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                          </select>
                                                        </div>
                                                        <div class="col">
                                                          @if (!$data->campaignGoals->profitable)
                                                          <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Engagement rate</label>
                                                            <input id="engagement_rate" class="form-control" type="number" value="0" min='0' max='100' />
                                                          </div>
                                                          @endif
                                                        </div>
                                                        {{-- <button onclick="sendStatusRequest()" class="btn btn-info h-25 mt-2">See</button> --}}
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div class="row p-4  align-items-center">
                                                      <h6 for="add_category">Videos</h6>
                                                      <button type="button" onclick="addVideoModal()" class="btn btn-info ml-2">Add</button>
                                                    </div>
                                                    <div id="videoSection" class="row video-section p-1">
                                                      @foreach ($data->videos as $key => $item)
                                                    
                                                          <div class="col-2 h-25 mt-2">
                                                             <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                               <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                                <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                                                              </a>
                                                                  <div class="ml-2">
                                                                      <h6 class="mb-0">Video #{{ $key+1 }}</h6>
                                                                      <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                      @endforeach
                                                    
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div class="row p-4  align-items-center">
                                                      <h6 for="add_category">Images</h6>
                                                      <button type="button" onclick="addVideoModal(1)" class="btn btn-info ml-2">Add</button>
                                                    </div>
                                                    <div class="row video-section p-1">
                                                      @foreach ($data->image  as $key => $item)
                                                    
                                                          <div class="col-2 h-25 mt-2">
                                                             <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                               <a href="{{ $item->url}}" target="_blank" rel="noopener noreferrer">
                                                                <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                                              
                                                                </a>
                                                                  <div class="ml-2">
                                                                      <h6 class="mb-0">Image #{{ $key+1 }}</h6>
                                                                      <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                          
                                                           
                                                          
                                                          
                                                      @endforeach
                                                    
                                                    </div>
                                                  </div>
                                                
                                                </form>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>LIVE</h3>
                                <section>
                                    <div class="add-section">
                                        <div class="blocks-table d-block">
                                          <table class="table zero-configuration table-influencers col-12" >
                                            <thead>
                                                <tr>
                                                  <th>Image</th>
                                                  <th>Full name</th>
                                                  <th>Match</th>
                                                  <th>Chosen</th>
                                                  <th>Status</th>
                                                  <th>Accepted</th>
                                                  <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                              @foreach ($matches as $item)
                                  <tr>
                                    <td>
                                    
                                      <div class="thumb">
                                        <img  class="img-fluid inf-image" src="{{ $item->influencers->users->infulncerImage?$item->influencers->users->infulncerImage['url']:null }}" alt="">
                                      </div>
                                    </td>

                                      <td>{{  $item->influencers->first_name }} {{  $item->influencers->middle_name }} {{  $item->influencers->last_name }}</td>
                                      <td>{{ $item->match }}%</td>
                                      <td>{{ $item->chosen ? 'Yes':'No' }}</td>
                                      <td>{{ $item->status  }}</td>
                                      <td>
                                      @if ($item->influencers->checkIfAccepted($data->id) == 1)
                                          Yes
                                        @elseif($item->influencers->checkIfAccepted($data->id) == 2)
                                        No Contract avalibale
                                          @else
                                          No
                                      @endif
                                    </td>
                                      <td>
                                        
                                        @if ($data->status == 'approve'||$data->status == 'fullpayment')
                                        <button {{ $item->influencers->checkIfAccepted($data->id) == 1?'disabled':'' }} type="button" onclick="seeContract('{{$data->contacts->content}}','{{ $item->influencers->id }}')" class="btn btn-secondary">
                                          <i class="bx bx-send "></i>
                                        </button> 
                                        @endif

                                        <button type="button" onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')" class="btn btn-secondary">
                                          <i class="bx bx-transfer"></i>
                                        </button> 
                                            

                                      
                                      </td>
                                  </tr>
                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            @else
                              <div class="col" id="wizard-basic">
                                <h3 class="sectionTitle">CAMPAIGN</h3>
                                <section>
                                  <div class="camp-section-show-status">
                                    <div class="add-section"><h3 class="f-16 ad-title" style="">Campaign Details ({{ $data->store }})</h3>
                                                                          <div class="blocks-list">
                                                                              <div class="w-100  justify-content-center">
                                                                                  <div class="details-banner ad-details">
                                                                                          <div class="row">
                                                                                            <div class="col-lg-2 col-md-3 text-center w-100">
                                                                                                  <img class="ad-image" src="{{ $data->customers->users->image['url'] }}" alt="Ahmed ahmed jo">
                                                                                                  <h3 class="title mt-2">{{ $data->customers->full_name }}</h3>
                                                                                              </div>
                                                                                              <div class="col details-content">
                                                                                                  <p>
                                                                                                      <b class="me-2">Name:</b> {{ $data->store }}
                                                                                                  </p><div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Description:</b> <span class="me-2">{{ $data->about }}</span>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="mr-2">Category:</b>
                                                                                                      @if($data->categories)
                                                                                                      
                                                                                                        <span class="tag mr-2 category-item">{{$data->categories->name }}</span>
                                                                                                        @else
                                                                                                        <span class="tag mr-2 category-item">No Category</span>
                                                                                                      @endif
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Cr Number : {{ $data->cr_num }}</b>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">is vat: {{ $data->is_vat?'Yes':'No' }}</b>
                                                                                                  </div>
                                                                                                  <div class="hashs border-top pt-1 pb-1">
                                                                                                      <b class="me-2">assoiate to ad: {{ $data->relation }} </b>
                                                                                                    </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">goal:</b> <span class="me-2">{{ $data->campaignGoals->title }}</span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">On: </b> <span class="me-2">
                                                                                                          @foreach ($data->socialMedias as $item) 
                                                                                                              <img src="{{ $item->image }}" class="rounded-circle social-media-icon" />
                                                                                                          @endforeach
                                                                                                      </span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Link: <a target="_blank" href="{{ $data->store_link }}">Click Me!</a> </b><span class="me-2">
                                                                                                      </span>
                                                                                                  </div>
                                                                                                  <div class="border-top pt-1 pb-1">
                                                                                                      <b class="me-2">Status: {{$data->status}} </b><span class="me-2">
                                                                                                      </span>
                                                                                                  </div>
                                                                                              </div>
                                                                                      </div>
                                                                                      <div class="">
                                                                                        <div class="container">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-6 col-md-12 p-2">
                                                                                                    <div class="count-box list">
                                                                                                        <span> <i class="bx bx-money"></i> Total Budget:</span>
                                                                                                        <span class="numbers">{{ $data->budget }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6 col-md-12 p-2">
                                                                                                    <div class="count-box list">
                                                                                                        <span> <i class="bx bx-user"></i> Influncer:</span>
                                                                                                        <span class="numbers">{{ count($matches) }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                  </div>
                                                                              </div>
                                                                            
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="w-100 d-flex justify-content-center">
                                                                    {{-- <button role="wizard-basic" type="button" class="btn btn-info w-50">
                                                                      Next
                                                                    </button> --}}
                                                                  </div>
                                </section>
                                @if($data->status !== 'rejected')
                                <h3 class="sectionTitle">CONTENT</h3>
                                <section>
                                    <div class="add-section contentSection">
                                        <div class="box-border">
                                            <div class="top-section">
                                                <div class="selected-items row">
                                                  
                                                </div>
                                            </div>
                                            <div class="main-section d-flex justify-content-center p-2">
                                              <div class="card col">
                                                <form>
                                                  <div class="col p-4">
                                                    <div >
                                                      <h6 for="add_category">Add Influncers Requarment</h6>
                                                      <div class="row p-4 add_space">
                                                        <div class="col">
                                                          <label for="">Type</label>
                                                          <select disabled class="form-control" id="ad_type">
                                                            <option {{ $data->type == 'product'?'selected':''}} value="product">Product</option>
                                                            <option {{ $data->type == 'service'?'selected':'' }} value="service">Service</option>
                                                          </select>
                                                        </div>
                                                        <div class="col">
                                                          <label for="">Category</label>
                                                          <select disabled class="form-control" id="ad_type">
                                                            @foreach ($categories as $item)
                                                          
                                                              <option {{ $data->category_id == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                          </select>
                                                        </div>
                                                        <div class="col">
                                                          @if (!$data->campaignGoals->profitable)
                                                          <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Engagement rate</label>
                                                            <input disabled id="engagement_rate" class="form-control" type="number" value="0" min='0' max='100' />
                                                          </div>
                                                          @endif
                                                        </div>
                                                        {{-- <button onclick="sendStatusRequest()" class="btn btn-info h-25 mt-2">See</button> --}}
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div class="row p-4  align-items-center">
                                                      <h6 for="add_category">Videos</h6>
                                                      <button type="button" onclick="addVideoModal()" class="btn btn-info ml-2">Add</button>
                                                    </div>
                                                    <div id="videoSection" class="row video-section p-1">
                                                      @foreach ($data->videos as $key => $item)
                                                    
                                                          <div class="col-3 h-25 mt-2">
                                                            <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                              <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                                <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                                                              </a>
                                                                  <div class="ml-2">
                                                                      <h6 class="mb-0">Video #{{ $key+1 }}</h6>
                                                                      <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                      @endforeach
                                                    
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div class="row p-4  align-items-center">
                                                      <h6 for="add_category">Images</h6>
                                                      <button type="button" onclick="addVideoModal(1)" class="btn btn-info ml-2">Add</button>
                                                    </div>
                                                    <div class="row video-section p-1">
                                                      @foreach ($data->image  as $key => $item)
                                                    
                                                          <div class="col-3 h-25 mt-2">
                                                            <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                              <a href="{{ $item->url}}" target="_blank" rel="noopener noreferrer">
                                                                <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                                              
                                                                </a>
                                                                  <div class="ml-2">
                                                                      <h6 class="mb-0">Image #{{ $key+1 }}</h6>
                                                                      <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                          
                                                          
                                                          
                                                          
                                                      @endforeach
                                                    
                                                    </div>
                                                  </div>
                                                
                                                </form>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3 class="sectionTitle" >Influencers</h3>
                                <section>
                                    <div class="live-section">
                                        <div class="blocks-table d-block">
                                          <table class="table zero-configuration table-influencers col-12" >
                                            <thead>
                                                <tr>
                                                  <th>Image</th>
                                                  <th>Full name</th>
                                                  <th>Match</th>
                                                  <th>Chosen</th>
                                                  <th>Status</th>
                                                  <th>Accepted</th>
                                                  <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                              @foreach ($matches as $item)
                                  <tr>
                                    <td>
                                    
                                      <div class="thumb">
                                        <img  class="img-fluid inf-image" src="{{ $item->influencers->users->infulncerImage?$item->influencers->users->infulncerImage['url']:null }}" alt="">
                                      </div>
                                    </td>
                            
                                      <td>{{  $item->influencers->first_name }} {{  $item->influencers->middle_name }} {{  $item->influencers->last_name }}</td>
                                      <td>{{ $item->match }}%</td>
                                      <td>{{ $item->chosen ? 'Yes':'No' }}</td>
                                      <td>{{ $item->status  }}</td>
                                      <td>
                                      @if ($item->influencers->checkIfAccepted($data->id) == 1)
                                          Yes
                                        @elseif($item->influencers->checkIfAccepted($data->id) == 2)
                                        No Contract avalibale
                                          @else
                                          No
                                      @endif
                                    </td>
                                      <td>
                                        
                                        @if ($data->status == 'choosing_influencer')
                                        <button {{ $item->influencers->checkIfAccepted($data->id) == 1?'disabled':'' }} type="button" onclick="seeContract('{{$data->contacts->content}}','{{ $item->influencers->id }}')" class="btn btn-secondary">
                                          <i class="bx bx-send "></i>
                                        </button> 
                                        @endif
                            
                                        <button type="button" onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')" class="btn btn-secondary">
                                          <i class="bx bx-transfer"></i>
                                        </button> 
                                            
                            
                                      
                                      </td>
                                  </tr>
                                    @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </section>
                                @endif
                              </div>
                          
                            @endif
                            {{-- <button class="btn btn-danger float-right">Reject</button> --}}

                        </div>
                    </form>
                </div>
            </div>
        
        <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                      <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close"><img src="images/Icon ionic-md-close-circle.svg" alt=""></button>
                    </div>
                    <div class="separate-line"></div>
                    <div class="modal-body p-0 pt-2">
                      <div class="container-fluid">
                          <div class="row">
                            <div class="form-field col-12 py-2">
                                <label class="form-label">Current Password</label>
                                <input class="form-control" type="text" placeholder="">
                            </div>
                            <div class="form-field col-12 py-2">
                                <label class="form-label">New Password</label>
                                <input class="form-control" type="text" placeholder="">
                            </div>
                            <div class="form-field col-12 py-2">
                                <label class="form-label">Confirm Password</label>
                                <input class="form-control" type="text" placeholder="">
                            </div>
                            <div class="separate-line pt-3"></div>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn submit btn-primary">Yes, Change it</button>
                    </div>
                  </div>
              </form>
            </div>
        </div>
       
          
        
        <div id="rejectedReson" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Rejected Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <textarea class="form-control" id="rejectedNote" rows="12"></textarea>
              </div>
              <div class="modal-footer">
                <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div id="expensiveType" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Ad type</label>
                  <select class="form-control" id="ad_type">
                    <option {{ $data->type == 'product'?'selected':''}} value="product">Product</option>
                    <option {{ $data->type == 'service'?'selected':'' }} value="service">Service</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Category</label>
                  <select class="form-control" id="category_id">
                    @foreach ($categories as $item)
                    <option {{ $data->category_id == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>

                @if (!$data->campaignGoals->profitable)
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Engagement rate</label>
                  <input id="engagement_rate" class="form-control" type="number" min='0' max='100' />
                </div>
                @endif

              </div>
              <div class="modal-footer">
                <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
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
                              
                              <tbody>
                                @foreach ($matches as $item)
                                <tr class="candidates-list bg-dnager">
                                  <td class="title">
                                    <div class="thumb">
                                    </div>
                                    <div class="candidate-list-details">
                                      <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                          <h5 class="mb-0">{{  $item->influencers->full_name }}</h5>
                                          <span style="font-size:12px;">{{ $item->match }}%</span><br/>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col">
                                      <button style="background:none; border:none;" onclick=" ('{{ $item->influencers->users->id }}')" class="float-right" href="http://" target="_blank" rel="noopener noreferrer">
                                        <h5 ><i class="bx bx-edit"></i></h5>
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                                
                                @endforeach
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

        <div  id="unchosen_inf" class="modal" tabindex="-1" role="dialog">
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
                              
                              <tbody>
                                @foreach ($unMatched as $item)
                                <tr class="candidates-list bg-dnager">
                                  <td class="title">
                                    <div class="thumb">
                                     
                                      <img class="img-fluid" src="{{ $item->influencers->users->infulncerImage?$item->influencers->users->infulncerImage['url']:null }}" alt="">
                                    </div>
                                    <div class="candidate-list-details">
                                      <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                          <h5 class="mb-0">{{  $item->influencers->first_name }} {{  $item->influencers->middle_name }} {{  $item->influencers->last_name }}</h5>
                                          <span style="font-size:12px;">{{ $item->match }}%</span><br/>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col">
                                      <button style="background:none; border:none;" onclick="replaceInfluncer('{{ $item->influencers->id }}',)" class="float-right" href="http://" target="_blank" rel="noopener noreferrer">
                                        <h5 >chose</i></h5>
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                                
                                @endforeach
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
                  <textarea name="content" id="contractContent" rows="10" cols="80"></textarea>  
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Scenario</label>
                    <textarea class="form-control" name="content" id="scenario" rows="10" cols="80"></textarea>  
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Date</label>
                    <input id="contractDate" value="" name="website_link" type="date" class="form-control" id="inputAddress2" placeholder="date">
                  </div>              
                </div>
              <div class="modal-footer">
                  <button class="btn btn-secondary text-center align-middle" onclick="sendContract()">
                     Send
                  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        
        <div id="myInput" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">File Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3 id="addFileIcon" class="text-center" ><i class="bx bx-video"></i></h3>
                <h3 id="addFileModalTitle" class="text-center">Add Video</h3>
                <p></p>
                <input type="file" id="adVideo" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="addVideo()" type="button" class="btn btn-primary">Upload</button>
              </div>
            </div>
          </div>
        </div>

        <div id="deleteFile" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              {{-- <div class="modal-header">
                <h5 class="modal-title">Deleteing Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> --}}
              <div class="modal-body deleteModal">
                {{-- <h3 id="addFileIcon" class="text-center mt-4" ><i class="bx bx-trash"></i></h3> --}}
                {{-- <h3 id="addFileModalTitle" class="text-center">Delete</h3> --}}
                <h1 class="wont">Delete</h1>
                <p>Are you sure you want to delete This File ? After Deleteing the file you will not be able to restore it</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="deleteFile()" type="button" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>

        <div id="loading" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> --}}
              </div>
             
            </div>
          </div>
        </div>




        </section>
</div>



@endsection

@section('scripts')

@if($data->status == 'pending' || $data->status == 'choosing_influencer')
<script src="{{asset('main2/js/jquery.steps.min.js')}}" type="text/javascript"></script>
@endif
<script>

// to know whate steps the user currently in
let userCurrentStep = 0;
let countMatches = '{{count($matches)}}';
let adStatus = '{{  $data->status }}';
let isConfirm = false;
if(adStatus != 'pending')
{
  userCurrentStep = 1;
}
if(countMatches > 0)
{
  userCurrentStep = 2
}
@if($data->status == 'pending')

var steps = $("#wizard-basic").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            enablePagination: true,
            enableAllSteps: false,
            startIndex:userCurrentStep,
            onInit:function(){
              if(adStatus == 'pending')
              {
                $('.actions').append(`<li class='list-dicration' aria-disabled="false"><button type='button' onclick='sendStatusRequest("rejected")' class='btn btn-danger' role="menuitem">Reject</button></li>`)
              }
            },
            onFinishing:function(){
              isConfirm = true;
              sendStatusRequest('Confirm');
              window.location.reload();
            },
            onStepChanging:function(event, currentIndex, nextIndex){
              //console.log('next index: ',nextIndex)
              if(nextIndex == 2)
              {
                let rate = '{{ $data->campaignGoals->profitable }}';
                let initValue = document.getElementById('engagement_rate')?document.getElementById('engagement_rate').value:0;

                if((rate&&initValue > 100) || (rate&&initValue < 0))
                {
                   alert('please add correct amout of rate')
                   return false;
                }
                isConfirm = false;
                
                sendStatusRequest();

                return true;

              
              }

                //sendStatusRequest();
                
                return true;
              
              
             
              }
            });

@endif

    $('#addressSection').hide();
    let ad_id = '{{ $data->id }}';

  let getLocalData = localStorage.getItem('rateData');
  if(getLocalData)
  {
    getLocalData = JSON.parse(getLocalData);
    let getRate = getLocalData[ad_id];
    if(getRate)
    {
      document.getElementById('engagement_rate').value = getRate;
    }
  }


  Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
      })

  
  let choosen_inf_id = 0;
  let showAddress = false;
  //var isConfirm = false;
  var notChange = null;

  let removed_inf = 0;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
CKEDITOR.replace('contractContent', {
      extraPlugins: 'placeholder',
      height: 220,
      removeButtons: 'PasteFromWord'
    });
  let fileType = null;
  let deletetedFileId = null;
  function changeStatus()
  {
    
    let statusValue = document.getElementById('status').value;

    if(statusValue == 'rejected')
    {
        $('#rejectedReson').modal('toggle');

    }
    else if(statusValue == 'approve')
    {
      $('#expensiveType').modal('toggle');

    }
    else
    {
      sendStatusRequest();
    }
    
  }

  function sendStatusRequest(status = null)
  {
   
    if(status == 'rejected')
    {
        $('#rejectedReson').modal('toggle');
        return;
    }
    $('#loading').modal({
      keyboard: false,
      backdrop: 'static'

    });

    if(status == 'Confirm')
    {
      
      let localData = JSON.parse(localStorage.getItem('rateData'));
      localData.splice(ad_id,1);
      localStorage.setItem('rateData',JSON.stringify(localData));
      isConfirm = true;
    }

    // SAVE DATA TO LOCAL
    let localData = localStorage.getItem('rateData');

    // IF THE LOCAL STORAGE HAVE DATA GET IT AND MAKE IT AN ARRAY
    if(localData&&status != 'Confirm') 
    {
      localData = JSON.parse(localStorage.getItem('rateData'))
      localData[ad_id] = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate').value : 0;
      localStorage.setItem('rateData',JSON.stringify(localData));
    }
    else
    {
      let array = [];
      array[ad_id] = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate').value : 0;
      localStorage.setItem('rateData',JSON.stringify(array));
    };

    let rate = '{{ $data->campaignGoals->profitable }}';
    let url  = '{{ route("dashboard.ads.update",":id") }}';
    let fullUrl = url.replace(':id','{{ $data->id }}');
    let initValue = document.getElementById('engagement_rate')?document.getElementById('engagement_rate').value:0;
    if((rate&&initValue > 100) || (rate&&initValue < 0))
    {
      return alert('please add correct amout of rate')
    }
    if(isConfirm)
    {
      url  = '{{ route("dashboard.ads.update",[":id",":confirm"]) }}';
      urlWithId = url.replace(':id','{{ $data->id }}');
      fullUrl = urlWithId.replace(':confirm',1);
    }
     status = 'approve';
    if(document.getElementById('rejectedNote').value)
    {
      status = 'rejected';
    }
    $('#loading').modal('show');

    $.ajax({
      url:fullUrl,
      type:'POST',
      data:{
        status:status,
        note:document.getElementById('rejectedNote').value,
        category_id:document.getElementById('category_id').value,
        engagement_rate:initValue,
        change:notChange,
        // ad_type:document.getElementById('ad_type').value,
        onSite:'{{ $data->onSite }}',
        adBudget:'{{ $data->budget }}',
        // expense_type:document.getElementById('expense_type').value,
        _token:'{{csrf_token()}}'
      },
      success:(res)=>{
        let url = '{{ route("dashboard.ads.index") }}'
        $('#loading').modal('hide');
        //return true;
        //location.reload();
        // uncomment this
        if(status == 'rejected')
        {
          window.location.reload();

        }
      },
      error:(err)=>{
        console.log("updateding error: ",err);
       alert('something wrong with updateing the ad');
      }
    })
  }

  function openModel()
  {
    $('#inf').modal('toggle');
  }

  function openCategoryModel(change = null)
  {
      isConfirm = false;
      notChange = true;
      console.log(notChange)
    $('#expensiveType').modal('toggle');
  }

  function getUnchosenInfulncers(inf_id)
  {
      removed_inf = inf_id;

      return  $('#unchosen_inf').modal('toggle');
  }

  function replaceInfluncer(inf_id,)
  {
        let url = '{{ route("dashboard.ads.changeMatch",[":id",":removed_inf",":chosen_inf"]) }}';
        let changeId = url.replace(':id','{{ $data->id }}');
        let changeInf = changeId.replace(':removed_inf',removed_inf);
        let chosenInf = changeInf.replace(':chosen_inf',inf_id)

        $.ajax({
            type:'GET',
            url:chosenInf,
            success:(res)=>{
                if(res.status != 200)
                {
                  return alert(res.msg)
                }
                location.reload();
            },
            error:(err)=>{
                console.log('delete admin Error')
            }
        });

  }

  function seeContract(content , inf_id)
  {
    choosen_inf_id = inf_id;
    $('#contractContent').empty();
    // $('#contractContent').append(content);
    //document.getElementById('contractContent').innerHTML = content;
    let obj =  CKEDITOR.instances['contractContent'];
    obj.setData(content)

    $('#seeContract').modal('toggle');
  }

  function sendContract()
  {
    let url = '{{ route("dashboard.ads.sendContractToInfluncer",":id") }}';
    let addId = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:addId,
      data:{
        influncers_id:choosen_inf_id,
        date:document.getElementById('contractDate').value,
        scenario:document.getElementById('scenario').value
      },
      type:'POST',
      success:(res)=>{
        document.getElementById('contractContent').value = '';
        location.reload();
        $('#seeContract').modal('toggle');
      },
      error:(err)=>{
        console.log('error: ',err);
      }
    })
    
  }

  function addVideoModal(type = null)
  {
    if(type)
    {
      fileType = type;
      $('#addFileModalTitle').html('Add Images');
      $('#addFileIcon').html('<i class="bx bx-image"></i>');
    }
    else
    {
      fileType = null;
      $('#addFileModalTitle').html('Add Videos');
      $('#addFileIcon').html('<i class="bx bx-video"></i>');
    }
    $('#myInput').modal('toggle');
  }

  function addVideo()
  {
    let video = document.getElementById("adVideo").files[0];
    let formData = new FormData();
    formData.append('file', video)
    let url = '{{route("dashboard.ads.uploadVideo",":id")}}';
    if(fileType) url = '{{route("dashboard.ads.uploadImage",":id")}}';
    let addIdToURL = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:addIdToURL,
      type:'POST',
      contentType: false,
      processData: false,
      data:formData,
      success:(res)=>{
        if(res.status == 200)
        {
          if(res.data.added_video)
          {
            $('#videoSection').append(`
            <div class="col-3 h-25 mt-2">
              <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                  <a href="${res.data.added_video.url}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                  </a>
              <div class="ml-2">
                <h6 class="mb-0">Video #${res.data.number_of_videos}</h6>
                <div class="about"><button onclick="deleteFileModal(${res.data.added_video.id})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                </div>
              </div>
              </div> 
            `);
          }
          else
          {
            $('#videoSection').append(`
            <div class="col-3 h-25 mt-2">
              <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                  <a href="${res.data.added_image.url}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                  </a>
              <div class="ml-2">
                <h6 class="mb-0">Video #${res.data.number_of_images}</h6>
                <div class="about"><button onclick="deleteFileModal(${res.data.added_image.id})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                </div>
              </div>
              </div>
            `);
          }

            $('#myInput').modal('toggle');

            Toast.fire({
            icon: 'success',
            title: 'File was uploaded successfully'
          })


        }
        else
        {
            Toast.fire({
            icon: 'error',
            title: 'server response :'+res.msg
          })
        }
      },
      error:(res)=>{
        
        let msg = res.responseJSON.err;
        if(!msg) msg = 'Server Error!'

        Toast.fire({
          icon: 'error',
          title: msg
        })

      }
    });

  }

  function deleteFileModal(id)
  {
    deletetedFileId = id;
    $('#deleteFile').modal('toggle');
  }

  function deleteFile()
  {
    let url = '{{ route("dashboard.ads.deleteFile",":id") }}';
    let updateUrl = url.replace(':id',deletetedFileId);
    $.ajax({
      url:updateUrl,
      type:'POST',
      data:{},
      success:(res)=>{
        console.log('res: ',res);
        location.reload();
      },
      error:(err)=>{
        console.log('err: ',err);
      }
    });
  }

  function mainForm()
  {
    $('#mainForm').submit();
  }

  function getAreas(id)
  {
    let route = '{{ route("dashboard.countries.index",":id") }}';
    let urlWithUpdate = route.replace(':id',id);
    $('#selectArea').empty();
    $('#selectCity').empty();

    $.ajax({
      url:urlWithUpdate,
      type:'GET',
      success:(res)=>{
        $('#selectArea').empty();
        
        let select = `<select id='selectAreasS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
        $('#selectArea').append(select);
        for (let index = 0; index < res.data.length; index++) {
          const element = res.data[index];
          let option = `<option value="${element.id}" >${element.name}</option>`
          $('#selectAreasS').append(option);
          $('#selectAreasS').append(option);
        }
      },
      error:(err)=>{
        Toast.fire({
            icon: 'error',
            title: 'server response'
        })
      }
    })

  }

  function getCities(id)
  {
    let route = '{{ route("dashboard.cities.index",":id") }}';
    let urlWithUpdate = route.replace(':id',id);

    $.ajax({
      url:urlWithUpdate,
      type:'GET',
      success:(res)=>{
        $('#selectCity').empty();
        
        let select = `<select id='selectCityS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
        $('#selectCity').append(select);
        for (let index = 0; index < res.data.length; index++) {
          const element = res.data[index];
          let option = `<option value="${element.id}" >${element.name}</option>`
          $('#selectCityS').append(option);
          $('#selectCityS').append(option);
          
        }
      },
      error:(err)=>{
        Toast.fire({
            icon: 'error',
            title: 'server response'
        })
      }
    })
  }

  function updateAddress(id)
  {
    if(!valdateAddress()) return;
    let route = '{{route("dashboard.ads.updateAddress",":id")}}';
    let url = route.replace(':id',id);
    let data = {
      country_id:document.getElementById('selectCountryS').value,
      city_id:document.getElementById('selectCityS').value,
      area_id:document.getElementById('selectAreasS').value
    }
    $.ajax({
      url:url,
      type:'POST',
      data:data,
      success:(res)=>{
        $('#selectCity').empty();
        $('#selectArea').empty();
        showAddress = false;
        Toast.fire({
            icon: 'success',
            title: 'Address was updated'
        })
        $('#addressSection').hide();

      },
      error:(err)=>{
        alert('err')
      }
    })
  }
  function setEditValue()
  {
    if(!showAddress)
    {
      $('#addressSection').show();
      showAddress = true;
    }
    else
    {
      $('#addressSection').hide();
      showAddress = false;
    }
  }

  function valdateAddress()
  {
    if(!document.getElementById('selectCountryS')||!document.getElementById('selectCityS')||!document.getElementById('selectAreasS'))
    {
      alert('Please fill all the data');
      return false;
    }
    return true;
  }
  



      
  

</script>

@endsection
