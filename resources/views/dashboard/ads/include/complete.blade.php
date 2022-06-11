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
                        <div class="row video-section p-1">
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
