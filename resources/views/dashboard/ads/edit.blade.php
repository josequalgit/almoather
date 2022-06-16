  @extends('dashboard.layout.index')
  @section('style')
  <link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">
  <link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
  @endsection
  @section('content')
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
                            @if ($data->status == 'pending' || $data->status == 'choosing_influencer')
                                <div id="wizard-basic">
                                    <h3>CAMPAIGN</h3>
                                    <section>
                                        <div class="camp-section">
                                            <div class="add-section">
                                                <h3 class="f-16 ad-title" style="">Campaign Details({{ $data->store }})</h3>
                                                <div class="blocks-list">
                                                    <div class="w-100  justify-content-center">
                                                        <div class="details-banner ad-details">
                                                            <div class="row">
                                                                <div class="col-lg-2 col-md-3 text-center w-100">
                                                                    <img class="ad-image" src="{{ $data->logo['url'] }}" alt="{{  $data->store }}">
                                                                    <h3 class="title mt-2">{{ $data->customers->full_name }}</h3>
                                                                </div>
                                                                <div class="col details-content">
                                                                    <div class="pb-1">
                                                                        <b class="me-2">Trade Mark Name:</b> <span class="me-2">{{ $data->store }}</span>
                                                                    </div>
                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="me-2">Cr Number : </b><span class="me-2">{{ $data->cr_num }}</span>
                                                                    </div>
                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="mr-2">Category:</b>
                                                                        @if ($data->categories)
                                                                            <span class="tag me-2 category-item">{{ $data->categories->name }}</span>
                                                                        @else
                                                                            <span class="tag me-2 category-item">No Category Choosen</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Description:</b> <span class="me-2">{{ $data->about }}</span>
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Is Store Verified Through Marouf:</b> <span class="me-2">{{ $data->marouf_num ? 'Yes' : 'No' }}</span>
                                                                    </div>
                                                                    @if($data->marouf_num)
                                                                        <div class="border-top pt-1 pb-1">
                                                                            <b class="me-2">Marouf Number:</b> <span class="me-2">{{ $data->marouf_num }}</span>
                                                                        </div>
                                                                    @endif
                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="me-2">is vat: </b><span class="me-2">{{ $data->is_vat ? 'Yes' : 'No' }}</span>
                                                                    </div>

                                                                    @if($data->is_vat)
                                                                        <div class="hashs border-top pt-1 pb-1">
                                                                            <b class="me-2">Tax Number: </b><span class="me-2">{{ $data->tax_value }}</span>
                                                                        </div>
                                                                    @endif
                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="me-2">Relationship With Brand: </b><span class="me-2">{{ $data->relation }}</span>
                                                                    </div>

                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="me-2">About The Company (Brand): </b><span class="me-2">{{ $data->about }}</span>
                                                                    </div>

                                                                    <div class="hashs border-top pt-1 pb-1">
                                                                        <b class="me-2">About The Product: </b><span class="me-2">{{ $data->about_product }}</span>
                                                                    </div>

                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Campaign Goals:</b> <span class="me-2">{{ $data->campaignGoals->title }}</span>
                                                                    </div>

                                                                    <h6>Location</h6>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Country:</b> <span class="me-2">{{ $data->countries->name }}</span>
                                                                    </div>
                                                                    <div class="pt-1 pb-1">
                                                                        <b class="me-2">City:</b> <span class="me-2">{{ $data->cities->name }}</span>
                                                                    </div>
                                                                    <div class="pt-1 pb-1">
                                                                        <b class="me-2">Area:</b> <span class="me-2">{{ $data->areas->name }}</span>
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">On: </b> <span
                                                                            class="me-2">
                                                                            @foreach ($data->socialMedias as $item)
                                                                                <img src="{{ $item->image }}" class="rounded-circle social-media-icon" />
                                                                            @endforeach
                                                                        </span>
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Link: <a target="_blank" href="{{ $data->store_link }}">{{ $data->store_link }}</a> </b>
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                      
                                                                        <b class="me-2">Commercial file: <a target="_blank" href="{{ $data->document->url }}">Show</a></b><span class="me-2"></span>
                                                                    </div>
                                                                  
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Document file: <a target="_blank" href="{{ $data->document->url }}">Show</a> </b><span class="me-2"></span>
                                                                    </div>
                                                                    <div class="border-top pt-1 pb-1">
                                                                        <b class="me-2">Status: {{ $data->status }} </b><span class="me-2"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-12 p-2">
                                                                            <div class="count-box list">
                                                                                <span> <i class="bx bx-money"></i>Total Budget:</span><span class="numbers">{{ $data->budget }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12 p-2">
                                                                            <div class="count-box list">
                                                                                <span> <i class="bx bx-user"></i>Influncer:</span><span class="numbers">{{ count($matches) }}</span>
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
                                        <div class="w-100 d-flex justify-content-center"></div>
                                    </section>
                                    <h3>CONTENT</h3>
                                    <section>
                                        <div class="add-section contentSection">
                                            <div class="box-border">
                                                <div class="top-section">
                                                    <div class="selected-items row"></div>
                                                </div>
                                                <div class="main-section d-flex justify-content-center p-2">
                                                    <div class="card col">
                                                        <form>
                                                            <div class="col p-4">
                                                                <div>
                                                                    <h6 for="add_category">Add Influncers Requarment</h6>
                                                                    <div class="row p-4 add_space">
                                                                        <div class="col">
                                                                            <label for="">Type</label>
                                                                            <select class="form-control" id="ad-type">
                                                                                <option {{ $data->type == 'product' ? 'selected' : '' }} value="product" data-items="{{json_encode($productCategories)}}" >Product</option>
                                                                                <option {{ $data->type == 'service' ? 'selected' : '' }} value="service" data-items="{{json_encode($serviceCategories)}}">Service</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="">Category</label>
                                                                            <select class="form-control" id="ad-category" data-item="{{$data->category_id}}"></select>
                                                                        </div>
                                                                        
                                                                        @if (!$data->campaignGoals->profitable)
                                                                            <div class="col">
                                                                                <div class="form-group">
                                                                                    <label for="exampleFormControlSelect1">Engagement rate</label>
                                                                                    <input id="engagement_rate" class="form-control" type="number" value="0" min='0' max='100' />
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row p-4  align-items-center">
                                                                    <h6 for="add_category">Videos</h6>
                                                                    <button type="button" class="btn btn-info ml-2 open-choose-video">Add</button>
                                                                    <input type="file" id="adVideo" style="display:none" />
                                                                </div>
                                                                <div id="videoSection" class="row video-section p-1">
                                                                    @foreach ($data->videos as $key => $item)
                                                                        <div class="col-2 h-25 mt-2">
                                                                            <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                                                    <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                                                                                </a>
                                                                                <div class="ml-2">
                                                                                    <h6 class="mb-0">Video #{{ $key + 1 }}</h6>
                                                                                    <div class="about"><button onclick="deleteFileModal( {{ $item->id }})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row p-4  align-items-center">
                                                                    <h6 for="add_category">Images</h6>
                                                                    <input type="file" id="adImage" style="display:none" />
                                                                </div>
                                                                <div id="imageSection" class="row image-section p-1">
                                                                    @foreach ($data->image as $key => $item)
                                                                        <div class="col-2 h-25 mt-2">
                                                                            <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                                                    <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                                                                </a>
                                                                                <div class="ml-2">
                                                                                    <h6 class="mb-0">Image #{{ $key + 1 }}</h6>
                                                                                    <div class="about"><button onclick="deleteFileModal( {{ $item->id }})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
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
                                                  <table class="table zero-configuration table-influencers col-12">
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
                                                                          <img class="img-fluid inf-image"
                                                                              src="{{ $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null }}"
                                                                              alt="">
                                                                      </div>
                                                                  </td>

                                                                  <td>{{ $item->influencers->first_name }}
                                                                      {{ $item->influencers->middle_name }}
                                                                      {{ $item->influencers->last_name }}</td>
                                                                  <td>{{ $item->match }}%</td>
                                                                  <td>{{ $item->chosen ? 'Yes' : 'No' }}</td>
                                                                  <td>{{ $item->status }}</td>
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

                                                                      @if ($data->status == 'approve' || $data->status == 'fullpayment')
                                                                          <button
                                                                              {{ $item->influencers->checkIfAccepted($data->id) == 1 ? 'disabled' : '' }}
                                                                              type="button"
                                                                              onclick="seeContract('{{ $data->contacts->content }}','{{ $item->influencers->id }}')"
                                                                              class="btn btn-secondary">
                                                                              <i class="bx bx-send "></i>
                                                                          </button>
                                                                      @endif

                                                                      <button type="button"
                                                                          onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')"
                                                                          class="btn btn-secondary">
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
                                              <div class="add-section">
                                                  <h3 class="f-16 ad-title" style="">Campaign Details
                                                      ({{ $data->store }})</h3>
                                                  <div class="blocks-list">
                                                      <div class="w-100  justify-content-center">
                                                          <div class="details-banner ad-details">
                                                              <div class="row">
                                                                  <div class="col-lg-2 col-md-3 text-center w-100">
                                                                      <img class="ad-image"
                                                                          src="{{ $data->customers->users->image['url'] }}"
                                                                          alt="Ahmed ahmed jo">
                                                                      <h3 class="title mt-2">
                                                                          {{ $data->customers->full_name }}</h3>
                                                                  </div>
                                                                  <div class="col details-content">
                                                                      <p>
                                                                          <b class="me-2">Name:</b>
                                                                          {{ $data->store }}
                                                                      </p>
                                                                      <div class="border-top pt-1 pb-1">
                                                                          <b class="me-2">Description:</b> <span
                                                                              class="me-2">{{ $data->about }}</span>
                                                                      </div>
                                                                      <div class="hashs border-top pt-1 pb-1">
                                                                          <b class="mr-2">Category:</b>
                                                                          @if ($data->categories)
                                                                              <span
                                                                                  class="tag mr-2 category-item">{{ $data->categories->name }}</span>
                                                                          @else
                                                                              <span class="tag mr-2 category-item">No
                                                                                  Category</span>
                                                                          @endif
                                                                      </div>
                                                                      <div class="hashs border-top pt-1 pb-1">
                                                                          <b class="me-2">Cr Number :
                                                                              {{ $data->cr_num }}</b>
                                                                      </div>
                                                                      <div class="hashs border-top pt-1 pb-1">
                                                                          <b class="me-2">is vat:
                                                                              {{ $data->is_vat ? 'Yes' : 'No' }}</b>
                                                                      </div>
                                                                      <div class="hashs border-top pt-1 pb-1">
                                                                          <b class="me-2">assoiate to ad:
                                                                              {{ $data->relation }} </b>
                                                                      </div>
                                                                      <div class="border-top pt-1 pb-1">
                                                                          <b class="me-2">goal:</b> <span
                                                                              class="me-2">{{ $data->campaignGoals->title }}</span>
                                                                      </div>
                                                                      <div class="border-top pt-1 pb-1">
                                                                          <b class="me-2">On: </b> <span
                                                                              class="me-2">
                                                                              @foreach ($data->socialMedias as $item)
                                                                                  <img src="{{ $item->image }}"
                                                                                      class="rounded-circle social-media-icon" />
                                                                              @endforeach
                                                                          </span>
                                                                      </div>
                                                                      <div class="border-top pt-1 pb-1">
                                                                          <b class="me-2">Link: <a
                                                                                  target="_blank"
                                                                                  href="{{ $data->store_link }}">Click
                                                                                  Me!</a> </b><span class="me-2">
                                                                          </span>
                                                                      </div>
                                                                      <div class="border-top pt-1 pb-1">
                                                                          <b class="me-2">Status:
                                                                              {{ $data->status }} </b><span
                                                                              class="me-2">
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="">
                                                                  <div class="container">
                                                                      <div class="row">
                                                                          <div class="col-lg-6 col-md-12 p-2">
                                                                              <div class="count-box list">
                                                                                  <span> <i class="bx bx-money"></i>
                                                                                      Total Budget:</span>
                                                                                  <span
                                                                                      class="numbers">{{ $data->budget }}</span>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-lg-6 col-md-12 p-2">
                                                                              <div class="count-box list">
                                                                                  <span> <i class="bx bx-user"></i>
                                                                                      Influncer:</span>
                                                                                  <span
                                                                                      class="numbers">{{ count($matches) }}</span>
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
                                          <div class="w-100 d-flex justify-content-center"></div>
                                      </section>
                                      @if ($data->status !== 'rejected')
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
                                                                      <div>
                                                                          <h6 for="add_category">Add Influncers Requarment
                                                                          </h6>
                                                                          <div class="row p-4 add_space">
                                                                              <div class="col">
                                                                                  <label for="">Type</label>
                                                                                  <select disabled class="form-control" id="ad_type">
                                                                                        <option {{ $data->type == 'product' ? 'selected' : '' }} value="product" data-items="{{json_encode($productCategories)}}">Product</option>
                                                                                        <option {{ $data->type == 'service' ? 'selected' : '' }} value="service" data-items="{{json_encode($serviceCategories)}}">Service</option>
                                                                                  </select>
                                                                              </div>
                                                                              <div class="col">
                                                                                  <label for="">Category</label>
                                                                                  <select disabled class="form-control"
                                                                                      id="ad_type">
                                                                                  </select>
                                                                              </div>
                                                                              <div class="col">
                                                                                  @if (!$data->campaignGoals->profitable)
                                                                                      <div class="form-group">
                                                                                          <label
                                                                                              for="exampleFormControlSelect1">Engagement
                                                                                              rate</label>
                                                                                          <input disabled
                                                                                              id="engagement_rate"
                                                                                              class="form-control"
                                                                                              type="number" value="0"
                                                                                              min='0' max='100' />
                                                                                      </div>
                                                                                  @endif
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col">
                                                                        <div class="row p-4  align-items-center">
                                                                            <h6 for="add_category">Videos</h6>
                                                                            <button type="button" class="btn btn-info ml-2 open-choose-video">Add</button>
                                                                            <input type="file" id="adVideo" />
                                                                        </div>
                                                                      <div id="videoSection" class="row video-section p-1">
                                                                          @foreach ($data->videos as $key => $item)
                                                                              <div class="col-3 h-25 mt-2">
                                                                                  <div
                                                                                      class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                                                      <a href="{{ $item->url }}"
                                                                                          target="_blank"
                                                                                          rel="noopener noreferrer">
                                                                                          <img src="{{ asset('img/icons/misc/mp4.jpg') }}"
                                                                                              width="40" />
                                                                                      </a>
                                                                                      <div class="ml-2">
                                                                                          <h6 class="mb-0">Video
                                                                                              #{{ $key + 1 }}</h6>
                                                                                          <div class="about">
                                                                                              <button
                                                                                                  onclick="deleteFileModal( {{ $item->id }})"
                                                                                                  type="button"
                                                                                                  class="deleteButton"><span
                                                                                                      class="small">Delete</span></button>
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                              </div>
                                                                          @endforeach

                                                                      </div>
                                                                  </div>
                                                                  <div class="col">
                                                                      <div class="row p-4  align-items-center">
                                                                          <h6 for="add_category">Images</h6>
                                                                          <button type="button" onclick="addVideoModal(1)"
                                                                              class="btn btn-info ml-2">Add</button>
                                                                      </div>
                                                                      <div id="imageSection" class="row video-section p-1">
                                                                          @foreach ($data->image as $key => $item)
                                                                              <div class="col-3 h-25 mt-2">
                                                                                  <div
                                                                                      class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                                                                      <a href="{{ $item->url }}"
                                                                                          target="_blank"
                                                                                          rel="noopener noreferrer">
                                                                                          <img src="{{ asset('img/icons/misc/img.png') }}"
                                                                                              width="40" />

                                                                                      </a>
                                                                                      <div class="ml-2">
                                                                                          <h6 class="mb-0">Image
                                                                                              #{{ $key + 1 }}</h6>
                                                                                          <div class="about">
                                                                                              <button
                                                                                                  onclick="deleteFileModal( {{ $item->id }})"
                                                                                                  type="button"
                                                                                                  class="deleteButton"><span
                                                                                                      class="small">Delete</span></button>
                                                                                          </div>
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
                                          <h3 class="sectionTitle">Influencers</h3>
                                          <section>
                                              <div class="live-section">
                                                  <div class="blocks-table d-block">
                                                      <table class="table zero-configuration table-influencers col-12">
                                                          <thead>
                                                              <tr>
                                                                  <th>Image</th>
                                                                  <th>Full name</th>
                                                                  <th>Match</th>
                                                                  <th>Chosen</th>
                                                                  <th>Status</th>
                                                                  <th>Ad Status</th>
                                                                  <th>Accepted</th>
                                                                  <th>Action</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody id="table-body">
                                                              @foreach ($matches as $item)
                                                                  <tr>
                                                                      <td>

                                                                          <div class="thumb">
                                                                              <img class="img-fluid inf-image"
                                                                                  src="{{ $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null }}"
                                                                                  alt="">
                                                                          </div>
                                                                      </td>

                                                                      <td>{{ $item->influencers->first_name }}
                                                                          {{ $item->influencers->middle_name }}
                                                                          {{ $item->influencers->last_name }}</td>
                                                                      <td>{{ $item->match }}%</td>
                                                                      <td>{{ $item->chosen ? 'Yes' : 'No' }}</td>
                                                                      <td>{{ $item->status }}</td>
                                                                      <td>{{ $item->contract ? ($item->contract->status ? 'Completed' : 'In Progress') : 'No Data' }}
                                                                      </td>
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

                                                                          @if ($data->status == 'approve' || $data->status == 'fullpayment')
                                                                              @if ($item->influencers->checkIfAccepted($data->id) == 1 && $item->contract->status == 1 && $item->contract->admin_status != 1)
                                                                                  <button type="button"
                                                                                      onclick="reject_data_inf('{{ $item->contract->id }}')"
                                                                                      class="btn btn-danger">
                                                                                      Reject
                                                                                  </button>
                                                                                  <button type="button"
                                                                                      onclick="accept_data_inf('{{ $item->contract->id }}')"
                                                                                      class="btn btn-success">
                                                                                      Accept
                                                                                  </button>
                                                                              @elseif($item->contract && $item->contract->admin_status == 1)
                                                                                  <button type="button"
                                                                                      class="btn btn-info">
                                                                                      Ad is Complted
                                                                                  </button>
                                                                              @else
                                                                                  <button
                                                                                      {{ $item->influencers->checkIfAccepted($data->id) == 1 ? 'disabled' : '' }}
                                                                                      type="button"
                                                                                      onclick="seeContract('{{ $data->contacts->content }}','{{ $item->influencers->id }}')"
                                                                                      class="btn btn-secondary">
                                                                                      <i class="bx bx-send "></i>
                                                                                  </button>
                                                                              @endif
                                                                          @endif
                                                                          @if ($item->contract && $item->contract->admin_status != 1)
                                                                              <button type="button"
                                                                                  onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')"
                                                                                  class="btn btn-secondary">
                                                                                  <i class="bx bx-transfer"></i>
                                                                              </button>
                                                                          @endif
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
                              <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save
                                  changes</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>

              <div id="inf" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Matched Inulncers</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
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
                                                                      <h5 class="mb-0">
                                                                          {{ $item->influencers->full_name }}</h5>
                                                                      <span
                                                                          style="font-size:12px;">{{ $item->match }}%</span><br />
                                                                  </div>
                                                              </div>

                                                          </div>
                                                          <div class="col">
                                                              <button style="background:none; border:none;"
                                                                  onclick=" ('{{ $item->influencers->users->id }}')"
                                                                  class="float-right" href="http://" target="_blank"
                                                                  rel="noopener noreferrer">
                                                                  <h5><i class="bx bx-edit"></i></h5>
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

              <div id="unchosen_inf" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Matched Inulncers</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="col">
                                  <div class="user-dashboard-info-box table-responsive mb-0 bg-white  shadow-sm">
                                      <table class="table manage-candidates-top mb-0">

                                          <tbody>
                                              @foreach ($unMatched as $item)
                                                  <tr class="candidates-list bg-dnager">
                                                      <td class="title">
                                                          <div class="thumb">

                                                              <img class="img-fluid"
                                                                  src="{{ $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null }}"
                                                                  alt="">
                                                          </div>
                                                          <div class="candidate-list-details">
                                                              <div class="candidate-list-info">
                                                                  <div class="candidate-list-title">
                                                                      <h5 class="mb-0">
                                                                          {{ $item->influencers->first_name }}
                                                                          {{ $item->influencers->middle_name }}
                                                                          {{ $item->influencers->last_name }}</h5>
                                                                      <span
                                                                          style="font-size:12px;">{{ $item->match }}%</span><br />
                                                                  </div>
                                                              </div>

                                                          </div>
                                                          <div class="col">
                                                              <button style="background:none; border:none;"
                                                                  onclick="replaceInfluncer('{{ $item->influencers->id }}',)"
                                                                  class="float-right" href="http://" target="_blank"
                                                                  rel="noopener noreferrer">
                                                                  <h5>chose</i></h5>
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
                                  <input id="contractDate" value="" name="website_link" type="date" class="form-control"
                                      id="inputAddress2" placeholder="date">
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

             
              <div id="reject_ad_contract" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-body">
                              <p>Add Reject Reason</p>
                              <textarea id="reject_ad_contract_input" class="form-control" id="rejectedNote" rows="12"></textarea>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" onclick="sendAdContractStatus('reject')"
                                  class="btn btn-primary">Send</button>
                          </div>
                      </div>
                  </div>
              </div>

            <div id="accept_ad_contract" class="modal accept_adcontract_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body accept_ad_contract_body">
                            <p>Please provide the ad link</p>
                            <input type="text" id="link_ad_contract_input" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="sendAdContractStatus()" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteFile" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-body deleteModal">
                              <h1 class="wont">Delete</h1>
                              <p>Are you sure you want to delete This File ? After Deleteing the file you will not be able
                                  to restore it</p>
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
                      </div>
                  </div>
              </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    @if ($data->status == 'pending' || $data->status == 'choosing_influencer')
        <script src="{{ asset('main2/js/jquery.steps.min.js') }}" type="text/javascript"></script>
    @endif
    <script>

        $(function(){
            $('#ad-type').on('change',function(){
                $('#ad-category').html('');
                let items = $('#ad-type option[value="'+$(this).val()+'"]').attr('data-items');
                items = JSON.parse(items) || [];
                items.forEach(element => {
                   $('#ad-category').append(`<option value="${element.id}">${element.name.en}</option>`) 
                });
            }).change();

            $('.open-choose-video').on('click',function(){
                $('#adVideo').trigger('click');
            });
            $('.open-choose-image').on('click',function(){
                $('#addImage').trigger('click');
            });

            $('#adVideo,#addImage').on('change',function(){
                var itemId = $(this).attr('id');
                let video = document.getElementById(itemId).files[0];
                let formData = new FormData();
                formData.append('file', video)
                let url = '{{ route('dashboard.ads.uploadVideo', ':id') }}';
                if (fileType) url = '{{ route('dashboard.ads.uploadImage', ':id') }}';
                let addIdToURL = url.replace(':id', '{{ $data->id }}');
                $.ajax({
                    url: addIdToURL,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: (res) => {
                            if (res.status == 200) {
                            if (res.data.added_video) {
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
                            } else {
                                $('#imageSection').append(`
                                    <div class="col-3 h-25 mt-2">
                                    <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                        <a href="${res.data.added_image.url}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                        </a>
                                    <div class="ml-2">
                                        <h6 class="mb-0">Image #${res.data.number_of_images}</h6>
                                        <div class="about"><button onclick="deleteFileModal(${res.data.added_image.id})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                        </div>
                                    </div>
                                    </div>
                                `);
                            }
                            Toast.fire({
                                icon: 'success',
                                title: 'File was uploaded successfully'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'server response :' + res.msg
                            });
                        }
                    },
                    error: (res) => {
                        let msg = res.responseJSON.err;
                        if (!msg) msg = 'Server Error!'

                        Toast.fire({
                            icon: 'error',
                            title: msg
                        })

                    }
                });
            });
        });
        // to know whate steps the user currently in
        let userCurrentStep = 0;
        let countMatches = '{{ count($matches) }}';
        let adStatus = '{{ $data->status }}';
        let isConfirm = false;
        if (adStatus != 'pending') {
            userCurrentStep = 1;
        }
        if (countMatches > 0) {
            userCurrentStep = 2
        }
        @if ($data->status == 'pending' || $data->status == 'choosing_influencer')

            var steps = $("#wizard-basic").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                enablePagination: true,
                enableAllSteps: false,
                startIndex: 2,
                onInit: function() {
                    if (adStatus == 'pending') {
                        $('.actions ul').prepend(`<li class='list-dicration' aria-disabled="false"><button type='button' onclick='sendStatusRequest("rejected")' class='btn btn-danger' role="menuitem">Reject</button></li>`)
                    }
                    $('.actions ul li:nth-child(2)').hide();
                },
                onFinishing: function() {
                    isConfirm = true;
                    sendStatusRequest('Confirm');
                    window.location.reload();
                },
                onStepChanging: function(event, currentIndex, nextIndex) {
                    if (nextIndex == 2) {
                        let rate = '{{ $data->campaignGoals->profitable }}';
                        let initValue = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate').value : 0;

                        if ((rate && initValue > 100) || (rate && initValue < 0)) {
                            alert('please add correct amout of rate')
                            return false;
                        }
                        isConfirm = false;
                        sendStatusRequest();
                    }

                    if (nextIndex == 0) {
                        $('.actions ul li:nth-child(2)').hide();
                        $('.actions ul li:nth-child(1)').show();
                    } else {
                        $('.actions ul li:nth-child(2)').show();
                        $('.actions ul li:nth-child(1)').hide();
                    }
                    return true;
                }
            });
        @endif

        $('#addressSection').hide();
        let ad_id = '{{ $data->id }}';

          let getLocalData = localStorage.getItem('rateData');
          if (getLocalData) {
              getLocalData = JSON.parse(getLocalData);
              let getRate = getLocalData[ad_id];
              if (getRate) {
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


          function sendStatusRequest(status = null) {

              if (status == 'rejected') {
                  $('#rejectedReson').modal('toggle');
                  return;
              }
              $('#loading').modal({
                  keyboard: false,
                  backdrop: 'static'

              });

              if (status == 'Confirm') {

                  let localData = JSON.parse(localStorage.getItem('rateData'));
                  localData.splice(ad_id, 1);
                  localStorage.setItem('rateData', JSON.stringify(localData));
                  isConfirm = true;
              }

              // SAVE DATA TO LOCAL
              let localData = localStorage.getItem('rateData');

              // IF THE LOCAL STORAGE HAVE DATA GET IT AND MAKE IT AN ARRAY
              if (localData && status != 'Confirm') {
                  localData = JSON.parse(localStorage.getItem('rateData'))
                  localData[ad_id] = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate')
                      .value : 0;
                  localStorage.setItem('rateData', JSON.stringify(localData));
              } else {
                  let array = [];
                  array[ad_id] = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate')
                      .value : 0;
                  localStorage.setItem('rateData', JSON.stringify(array));
              };

              let rate = '{{ $data->campaignGoals->profitable }}';
              let url = '{{ route('dashboard.ads.update', ':id') }}';
              let fullUrl = url.replace(':id', '{{ $data->id }}');
              let initValue = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate').value :
                  0;
              if ((rate && initValue > 100) || (rate && initValue < 0)) {
                  return alert('please add correct amout of rate')
              }
              if (isConfirm) {
                  url = '{{ route('dashboard.ads.update', [':id', ':confirm']) }}';
                  urlWithId = url.replace(':id', '{{ $data->id }}');
                  fullUrl = urlWithId.replace(':confirm', 1);
              }
              status = 'approve';
              if (document.getElementById('rejectedNote').value) {
                  status = 'rejected';
              }

              $.ajax({
                  url: fullUrl,
                  type: 'POST',
                  data: {
                      status: status,
                      note: document.getElementById('rejectedNote').value,
                      category_id: document.getElementById('category_id').value,
                      engagement_rate: initValue,
                      change: notChange,
                      onSite: '{{ $data->onSite }}',
                      adBudget: '{{ $data->budget }}',
                      _token: '{{ csrf_token() }}'
                  },
                  success: (res) => {
                      let url = '{{ route('dashboard.ads.index') }}'
                      location.reload();
                  },
                  error: (err) => {
                      console.log("updateding error: ", err);
                      alert('something wrong with updateing the ad');
                  }
              })
          }

          function openModel() {
              $('#inf').modal('toggle');
          }


          function getUnchosenInfulncers(inf_id) {
              removed_inf = inf_id;

              return $('#unchosen_inf').modal('toggle');
          }

          function replaceInfluncer(inf_id, ) {
              let url = '{{ route('dashboard.ads.changeMatch', [':id', ':removed_inf', ':chosen_inf']) }}';
              let changeId = url.replace(':id', '{{ $data->id }}');
              let changeInf = changeId.replace(':removed_inf', removed_inf);
              let chosenInf = changeInf.replace(':chosen_inf', inf_id)

              $.ajax({
                  type: 'GET',
                  url: chosenInf,
                  success: (res) => {
                      if (res.status != 200) {
                          return alert(res.msg)
                      }
                      location.reload();
                  },
                  error: (err) => {
                      console.log('delete admin Error')
                  }
              });

          }

          function seeContract(content, inf_id) {
              choosen_inf_id = inf_id;
              $('#contractContent').empty();
              let obj = CKEDITOR.instances['contractContent'];
              obj.setData(content)

              $('#seeContract').modal('toggle');
          }

          function sendContract() {
              let url = '{{ route('dashboard.ads.sendContractToInfluncer', ':id') }}';
              let addId = url.replace(':id', '{{ $data->id }}');
              $.ajax({
                  url: addId,
                  data: {
                      influncers_id: choosen_inf_id,
                      date: document.getElementById('contractDate').value,
                      scenario: document.getElementById('scenario').value
                  },
                  type: 'POST',
                  success: (res) => {
                      document.getElementById('contractContent').value = '';
                      location.reload();
                      $('#seeContract').modal('toggle');
                  },
                  error: (err) => {
                      console.log('error: ', err);
                  }
              })

          }

        function deleteFileModal(id) {
            deletetedFileId = id;
            $('#deleteFile').modal('toggle');
        }

          function deleteFile() {
              let url = '{{ route('dashboard.ads.deleteFile', ':id') }}';
              let updateUrl = url.replace(':id', deletetedFileId);
              $.ajax({
                  url: updateUrl,
                  type: 'POST',
                  data: {},
                  success: (res) => {
                      console.log('res: ', res);
                      location.reload();
                  },
                  error: (err) => {
                      console.log('err: ', err);
                  }
              });
          }

          function mainForm() {
              $('#mainForm').submit();
          }

          function getAreas(id) {
              let route = '{{ route('dashboard.countries.index', ':id') }}';
              let urlWithUpdate = route.replace(':id', id);
              $('#selectArea').empty();
              $('#selectCity').empty();

              $.ajax({
                  url: urlWithUpdate,
                  type: 'GET',
                  success: (res) => {
                      $('#selectArea').empty();

                      let select =
                          `<select id='selectAreasS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
                      $('#selectArea').append(select);
                      for (let index = 0; index < res.data.length; index++) {
                          const element = res.data[index];
                          let option = `<option value="${element.id}" >${element.name}</option>`
                          $('#selectAreasS').append(option);
                          $('#selectAreasS').append(option);
                      }
                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'server response'
                      })
                  }
              })

          }

          function getCities(id) {
              let route = '{{ route('dashboard.cities.index', ':id') }}';
              let urlWithUpdate = route.replace(':id', id);

              $.ajax({
                  url: urlWithUpdate,
                  type: 'GET',
                  success: (res) => {
                      $('#selectCity').empty();

                      let select =
                          `<select id='selectCityS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
                      $('#selectCity').append(select);
                      for (let index = 0; index < res.data.length; index++) {
                          const element = res.data[index];
                          let option = `<option value="${element.id}" >${element.name}</option>`
                          $('#selectCityS').append(option);
                          $('#selectCityS').append(option);

                      }
                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'server response'
                      })
                  }
              })
          }

          function updateAddress(id) {
              if (!valdateAddress()) return;
              let route = '{{ route('dashboard.ads.updateAddress', ':id') }}';
              let url = route.replace(':id', id);
              let data = {
                  country_id: document.getElementById('selectCountryS').value,
                  city_id: document.getElementById('selectCityS').value,
                  area_id: document.getElementById('selectAreasS').value
              }
              $.ajax({
                  url: url,
                  type: 'POST',
                  data: data,
                  success: (res) => {
                      $('#selectCity').empty();
                      $('#selectArea').empty();
                      showAddress = false;
                      Toast.fire({
                          icon: 'success',
                          title: 'Address was updated'
                      })
                      $('#addressSection').hide();

                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'Erro updateing address'
                      })
                  }
              })
          }

          function setEditValue() {
              if (!showAddress) {
                  $('#addressSection').show();
                  showAddress = true;
              } else {
                  $('#addressSection').hide();
                  showAddress = false;
              }
          }

          function valdateAddress() {
              if (!document.getElementById('selectCountryS') || !document.getElementById('selectCityS') || !document
                  .getElementById('selectAreasS')) {
                  alert('Please fill all the data');
                  return false;
              }
              return true;
          }

          let chossen_contract_id = 0;

          function reject_data_inf(contract_id) {
              chossen_contract_id = contract_id
              $('#reject_ad_contract').modal('toggle');

          }

          function accept_data_inf(contract_id) {
              chossen_contract_id = contract_id
              $('#accept_ad_contract').modal('toggle');
          }

          function sendAdContractStatus(reject = null) {
              let rejectNote = document.getElementById('reject_ad_contract_input').value;
              let link = document.getElementById('link_ad_contract_input').value;

              if (reject && !rejectNote) {
                  Toast.fire({
                      icon: 'error',
                      title: 'Please add the rejct reason'
                  })
                  return;
              }

              if (!reject && !link) {
                  Toast.fire({
                      icon: 'error',
                      title: 'Please add the ad link'
                  })
                  return;
              }


              let url = '{{ route('dashboard.ads.changeStatus', ':contract_id') }}';
              let urlWithContractId = url.replace(':contract_id', chossen_contract_id);
              $.ajax({
                  url: urlWithContractId,
                  type: 'POST',
                  data: {
                      status: rejectNote ? 0 : 1,
                      rejectNote,
                      link
                  },
                  success: (res) => {
                      window.location.reload()
                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'Erro updateing influncer'
                      })
                      console.log('Error changeing the status: ', err)
                  },
              })
          }
      </script>
  @endsection
