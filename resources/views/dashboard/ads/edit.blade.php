  @extends('dashboard.layout.index')
@section('content')
<style>
  #ad_image{
    max-width: 100% !important;
    height: 200px !important;
  }
  /* .modal{
    display: block !important; /* I added this to see the modal, you don't need this */
} */

/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 50vh;
    overflow-y: auto;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}    

/* user-dashboard-info-box */
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

.inf-image{
  width: 150px;
  border-radius: 13px;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<div class="app-content content p-5 mt-5">
    
    <section id="basic-input">
        <div class="card p-5">
          @if($errors->any())
          <div class="alert alert-danger" role="alert"> There is something wrong
              @foreach ($errors->all() as $error )
                  <li>{{$error}}</li>
              @endforeach
          </div>
          @endif
        
        <form method="post" enctype="multipart/form-data">
           @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Type</label>
                <input disabled value="{{ old('type')?old('type'):$data->type}}" name="type" type="full_name" class="form-control" id="inputtype4" placeholder="type">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Store</label>
                <input disabled value="{{ old('store')?old('store'):$data->store}}" name="store" type="text" class="form-control" id="inputstore4" placeholder="store">
              </div>
            </div>
           
            <div class="form-group">
            
              <label for="inputAddress2">Customer</label>
              <input disabled value="{{ $data->customers->full_name }}" name="budget" type="text" class="form-control" id="inputAddress2" placeholder="Customer Name">
            </div>
            {{-- @if ($data->influncers)
            <div class="form-group">
              <label for="inputAddress2">Influencer</label>
              <input disabled value="{{ old('influncer_id')?old('influncer_id'):$data->influncers->first_name.' '.$data->customers->last_name}}" name="budget" type="text" class="form-control" id="inputAddress2" placeholder="budget">
            </div>
            @endif --}}
            <div class="form-group">
              <label for="inputAddress2">Budget</label>
              <input disabled value="{{ old('budget')?old('budget'):$data->budget}}" name="budget" type="text" class="form-control" id="inputAddress2" placeholder="budget">
            </div>
            @if($data->ad_script)
            <div class="form-group">
              <label for="inputAddress2">Ad Script</label>
              <input disabled value="{{ old('ad_script')?old('ad_script'):$data->ad_script}}" name="ad_script" type="text" class="form-control" id="inputAddress2" placeholder="ad_script">
            </div>
            @endif
            @if($data->cr_num)
            <div class="form-group">
              <label for="inputAddress2">Certificate number</label>
              <input disabled value="{{ old('cr_num')?old('cr_num'):$data->cr_num}}" name="cr_num" type="text" class="form-control" id="inputAddress2" placeholder="cr_num">
            </div>
            @endif
          
            <div class="form-group">
                <label for="inputAddress2">Is Onsite</label>
                <input disabled value="{{ old('onSite')?old('onSite'):($data->onSite?'Yes':'No')}}" name="onSite" type="text" class="form-control" id="inputAddress2" placeholder="onSite">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Goal</label>
                <input disabled value="{{ old('campaign_goals_id')?old('campaign_goals_id'):($data->campaignGoals->title)}}" name="campaign_goals_id" type="text" class="form-control" id="inputAddress2" placeholder="campaign_goals_id">
            </div>
            @if($data->store_link)
            <div class="form-group">
                <label for="inputAddress2">Store Link</label>
                <input disabled value="{{ old('store_link')?old('store_link'):$data->store_link}}" name="store_link" type="text" class="form-control" id="inputAddress2" placeholder="store_link">
            </div>
            @endif

            @if($data->marouf_num)
            <div class="form-group">
                <label for="inputAddress2">Marouf Number</label>
                <input disabled value="{{ old('marouf_num')?old('marouf_num'):$data->marouf_num}}" name="marouf_num" type="text" class="form-control" id="inputAddress2" placeholder="marouf_num">
            </div>
            @endif

            @if($data->discount_code)
            <div class="form-group">
                <label for="inputAddress2">Discount Code</label>
                <input disabled value="{{ old('discount_code')?old('discount_code'):$data->discount_code}}" name="discount_code" type="text" class="form-control" id="inputAddress2" placeholder="discount_code">
            </div>
            @endif

            @if($data->social_media_id)
            <div class="form-group">
                <label for="inputAddress2">Spcial Media</label>
                <input disabled value="{{ old('social_media_id')?old('social_media_id'):$data->socialMedias->name}}" name="social_media_id" type="text" class="form-control" id="inputAddress2" placeholder="social_media_id">
            </div>
            @endif

            {{-- <div class="form-group">
                <label for="inputAddress2">Social Media</label>
                <input disabled value="{{ old('social_media_id')?old('social_media_id'):$data->socialMedias->name}}" name="social_media_id" type="text" class="form-control" id="inputAddress2" placeholder="social_media_id">
            </div> --}}
          
            <div class="form-group">
                <label for="inputAddress2">Country</label>
                <input disabled value="{{ old('country_id')?old('country_id'):$data->countries->name}}" name="country_id" type="text" class="form-control" id="inputAddress2" placeholder="country_id">
            </div>
            <div class="form-group">
                <label for="inputAddress2">City</label>
                <input disabled value="{{ old('city_id')?old('city_id'):$data->cities->name}}" name="city_id" type="text" class="form-control" id="inputAddress2" placeholder="city_id">
            </div>
          
            <div class="form-group">
                <label for="inputAddress2">Area</label>
                <input disabled value="{{ old('area_id')?old('area_id'):$data->areas?->name}}" name="area_id" type="text" class="form-control" id="inputAddress2" placeholder="area_id">
            </div>

            <div class="form-group">
                <label for="inputAddress2">About</label>
                <textarea class="form-control" disabled rows="11">{{ $data->about }}</textarea>
            </div>

            @if($data->expense_type !== 'none')
            <div class="form-group">
                <label for="inputAddress2">Expense type</label>
                <textarea class="form-control" disabled rows="11">{{ $data->expense_type }}</textarea>
            </div>
            @endif
            
            @if($data->reject_note)
            <div class="form-group">
                <label for="inputAddress2">Reject Note</label>
                <textarea class="form-control" disabled rows="11">{{ $data->reject_note }}</textarea>
            </div>
            @endif

            @if($data->scenario)
            <div class="form-group">
                <label for="inputAddress2">Scenario</label>
                <textarea class="form-control" disabled rows="11">{{ $data->scenario }}</textarea>
            </div>
            @endif

            <div class="form-group">
              {{-- <label class="col mb-2" for="inputAddress2">Image</label>
              <a target="_blank" download href="{{ $data->image }}">
              <img id="ad_image" src="{{ $data->image }}" /> --}}
            </a>
              
            </div>
            @if ($data->document)
            <div class="form-group">
              <label class="col mb-2" for="inputAddress2">document</label>
              <a target="_blank" download href="{{ $data->document }}">
                <img src="{{ $data->document }}" />
              </a>
             
            </div>
                
            @endif
          
            @if($data->videos&&count($data->videos))
            @foreach ($data->videos as $item)
            <div class="form-group">
              <label class="col mb-2" for="inputAddress2">Videos</label>
              <video class="col" width="320" height="240" controls>
                <source src="{{ $data->item }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
            @endforeach
            @endif

            {{-- <button type="button" class="btn btn-secondary mt-2 mb-2">
              <i class="bx bx-show white" aria-hidden="true"></i>
            </button> --}}
            {{-- <div class="form-group">
              <label class="col mb-2" for="inputAddress2">Matched</label>
              <button  {{ $data->status != 'approve'?'disabled':''}} onclick="openModel()" id="myModal" type="button" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#exampleModal">
                <i class="bx bx-show white" aria-hidden="true"></i>
              </button>
              
            </div> --}}
           
            

            <div class="form-group">
              <label for="inputAddress2">Status</label>
              @if($data->status == 'pending'||$data->status == 'rejected')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option {{ $data->status == 'approve'?'selected':'' }} value="approve">Approve</option>
                {{-- <option disabled {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
                <option disabled {{ $data->status == 'fullpayment'?'selected':'' }} value="fullpayment">Full Paymet</option>
                <option disabled {{ $data->status == 'progress'?'selected':'' }} value="progress">Progress</option>
                <option disabled {{ $data->status == 'complete'?'selected':'' }} value="complete">Complete</option> --}}
              </select>
              @elseif($data->status == 'approve'||$data->status == 'prepay'||$data->status == 'fullpayment')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option disabled {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option disabled {{ $data->status == 'approve'?'selected':'' }} value="approve">Approve</option>
                <option disabled {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
                {{-- <option disabled {{ $data->status == 'fullpayment'?'selected':'' }} value="fullpayment">Full Paymet</option>
                <option disabled {{ $data->status == 'progress'?'selected':'' }} value="progress">Progress</option>
                <option disabled {{ $data->status == 'complete'?'selected':'' }} value="complete">Complete</option> --}}
              </select>
              @else
             
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                {{-- <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option disabled {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option disabled {{ $data->status == 'approve'?'selected':'' }} value="approve">Approve</option> --}}
                <option   {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
                <option disabled {{ $data->status == 'fullpayment'?'selected':'' }} value="fullpayment">Full Paymet</option>
                <option disabled {{ $data->status == 'progress'?'selected':'' }} value="progress">Progress</option>
                <option  {{ $data->status == 'complete'?'selected':'' }} value="complete">Complete</option>
              </select>
              @endif
          
              @can('Edit Ads')
                @if($data->status == 'rejected'||$data->status == 'pending'||$data->status == 'complete'||$data->status == 'progress')
                  <button onclick="changeStatus()" type="button" class="mt-2 btn btn-primary float-right">Change</button>
                @endif 
              @endcan
              
            </div>

            <div class="table-responsive mt-2">
              <label class="col mb-2" for="inputAddress2">Matched</label>
              <table class="table zero-configuration">
                  <thead>
                      <tr>
                          <th>Image</th>
                          <th>Full name</th>
                          <th>Match</th>
                          <th>Chosen</th>
                          <th>Accepted</th>
                          <th>Action</th>
                          {{-- <th>Action</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($matches as $item)
                              <tr>
                                <td>
                                  <div class="thumb">
                                    {{-- <img  class="img-fluid inf-image" src="{{ $item->influencers->users->infulncerImage }}" alt=""> --}}
                                  </div>
                                </td>

                                {{-- @php
                                  dd($item->influencers->checkIfAccepted($data->id));    
                                @endphp --}}
                                  <td>{{  $item->influencers->full_name }}</td>
                                  <td>{{ $item->match }}%</td>
                                  <td>{{ $item->chosen ? 'Yes':'No' }}</td>
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
                                    
                                    
                                    <button {{ $item->influencers->checkIfAccepted($data->id) == 1?'disabled':'' }} type="button" onclick="seeContract('{{$data->contacts->content}}','{{ $item->influencers->id }}')" class="btn btn-secondary">
                                      <i class="bx bx-send"></i>
                                     </button> 

                                     {{-- @if ($item->status == 'pending')
                                     <button disabled  class="btn btn-secondary" href="{{ route('dashboard.ads.editContract',$item->id) }}">
                                      <i class="bx bx-book-content"></i>
                                     </button> 
                                     @elseif($item->status == 'fullpayment'||$item->status == 'progress'||$item->status == 'influncer_complete'||$item->status == 'complete'||$item->status == 'incomplete'||$item->status == 'rejected')
                                     <button  onclick="openModalSeeContract('{{ $item->contacts->content }}')" class="btn btn-secondary">
                                      <i class="bx bx-book-content"></i>
                                     </button> 
                                         @else
                                         <a  class="btn btn-secondary" href="{{ route('dashboard.ads.editContract',$item->id) }}">
                                          <i class="bx bx-book-content"></i>
                                         </a> 
                                     @endif --}}
                                   
                                  </td>
                              </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
      {{-- @can('See Ads')
      <div class="p-1">
          {{ $data->links('pagination::bootstrap-5') }}
      </div>
      @endcan --}}
           

          </form>
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
                  <label for="exampleFormControlSelect1">Expence type</label>
                  <select class="form-control" id="expense_type">
                    <option value="pvn">PVN</option>
                    <option value="pve">PVE</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Ad type</label>
                  <select class="form-control" id="ad_type">
                    <option value="product">Product</option>
                    <option value="service">Service</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Category</label>
                  <select class="form-control" id="category_id">
                    @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Date</label>
                  <input id="date" value="" name="website_link" type="date" class="form-control" id="inputAddress2" placeholder="date">
                </div>
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
                              {{-- <thead>
                                <tr>
                                  <th>Candidate Name</th>
                                  <th class="text-center">Status</th>
                                  <th class="action text-right">Action</th>
                                </tr>
                              </thead> --}}
                              <tbody>
                                @foreach ($matches as $item)
                                <tr class="candidates-list bg-dnager">
                                  <td class="title">
                                    <div class="thumb">
                                      {{-- <img class="img-fluid" src="{{ $item->influencers->users->infulncerImage }}" alt=""> --}}
                                    </div>
                                    <div class="candidate-list-details">
                                      <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                          <h5 class="mb-0">{{  $item->influencers->full_name }}</h5>
                                          <span style="font-size:12px;">{{ $item->match }}%</span><br/>
                                          {{-- <a href="#" class="text-info float-right" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a> --}}
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
                {{-- <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button> --}}
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
                              {{-- <thead>
                                <tr>
                                  <th>Candidate Name</th>
                                  <th class="text-center">Status</th>
                                  <th class="action text-right">Action</th>
                                </tr>
                              </thead> --}}
                              <tbody>
                                @foreach ($unMatched as $item)
                                <tr class="candidates-list bg-dnager">
                                  <td class="title">
                                    <div class="thumb">
                                      <img class="img-fluid" src="{{ $item->influencers->users->infulncerImage }}" alt="">
                                    </div>
                                    <div class="candidate-list-details">
                                      <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                          <h5 class="mb-0">{{  $item->influencers->full_name }}</h5>
                                          <span style="font-size:12px;">{{ $item->match }}%</span><br/>
                                          {{-- <a href="#" class="text-info float-right" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a> --}}
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col">
                                      <button style="background:none; border:none;" onclick="replaceInfluncer('{{ $item->influencers->users->id }}',)" class="float-right" href="http://" target="_blank" rel="noopener noreferrer">
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
                {{-- <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button> --}}
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
                  {{-- <p id="contractContent">
  
                  </p> --}}
                  <textarea name="content" id="contractContent" rows="10" cols="80"></textarea>  
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Date</label>
                    <input id="contractDate" value="" name="website_link" type="date" class="form-control" id="inputAddress2" placeholder="date">
                  </div>              </div>
              <div class="modal-footer">
                  <button class="btn btn-secondary text-center align-middle" onclick="sendContract()">
                     Send
                  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        

        </section>

      
</div>



@endsection
@section('scripts')
<script>
  var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
var yyyy = today.getFullYear();
let choosen_inf_id = 0;

if(dd<10){
  dd='0'+dd
} 
if(mm<10){
  mm='0'+mm
} 

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("date").setAttribute("min", today);
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

  function sendStatusRequest()
  {
    let url  = '{{ route("dashboard.ads.update",":id") }}';
    let urlWithId = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:urlWithId,
      type:'POST',
      data:{
        status:document.getElementById('status').value,
        note:document.getElementById('rejectedNote').value,
        category_id:document.getElementById('category_id').value,
        ad_type:document.getElementById('ad_type').value,
        date:document.getElementById('date').value,
        onSite:'{{ $data->onSite }}',
        adBudget:'{{ $data->budget }}',
        expense_type:document.getElementById('expense_type').value
      },
      success:(res)=>{
        let url = '{{ route("dashboard.ads.index") }}'
        // uncomment this
       window.location.href = url;
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

  function getUnchosenInfulncers(inf_id)
  {
      removed_inf = inf_id;
      $('#inf').modal('toggle');

      return $('#unchosen_inf').modal('toggle');
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
    CKEDITOR.instances['contractContent'].setData(content);

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
        date:document.getElementById('contractDate').value
      },
      type:'POST',
      success:(res)=>{
        document.getElementById('contractContent').value = '';
        console.log('success: ',res);
        $('#seeContract').modal('toggle');
      },
      error:(err)=>{
        console.log('error: ',err);
      }
    })
    
  }
  

</script>
@endsection
