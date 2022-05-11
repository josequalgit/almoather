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
i.bx.bx-video {
    font-size: 116px;
}
i.bx.bx-image {
    font-size: 116px;
}
i.bx.bx-trash {
    font-size: 116px;
}
#headerPopup{
  width:75%;
  margin:0 auto;
}

#headerPopup iframe{
  width:100%;
  margin:0 auto;
}
#fade {
  display: none;
  position: fixed;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 100%;
  background-color: black;
  z-index: 1001;
  -moz-opacity: 0.8;
  opacity: .80;
  filter: alpha(opacity=80);
}

#light {
  display: none;
  position: absolute;
  top: 50%;
  left: 50%;
  max-width: 600px;
  max-height: 360px;
  margin-left: -300px;
  margin-top: -180px;
  border: 2px solid #FFF;
  background: #FFF;
  z-index: 1002;
  overflow: visible;
}

#boxclose {
  float: right;
  cursor: pointer;
  color: #fff;
  border: 1px solid #AEAEAE;
  border-radius: 3px;
  background: #222222;
  font-size: 31px;
  font-weight: bold;
  display: inline-block;
  line-height: 0px;
  padding: 11px 3px;
  position: absolute;
  right: 2px;
  top: 2px;
  z-index: 1002;
  opacity: 0.9;
}

.boxclose:before {
  content: "×";
}

#fade:hover ~ #boxclose {
  display:none;
}

.test:hover ~ .test2 {
  display: none;
}
.deleteButton{
    border: none;
    background: none;
}

.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
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
        
        <form id="mainForm" action="{{ route('dashboard.ads.updateBasic',$data->id ) }}" method="post" enctype="multipart/form-data">
           @csrf

           <div class="container">
            <div class="main-body">
                  <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ $data->customers->users->image?$data->customers->users->image['url']:null }}" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                              <h5>{{ $data->customers->first_name }} {{ $data->customers->middle_name }} {{ $data->customers->last_name }}</h5>
                              <p class="text-secondary mb-1">Customer</p>
                              {{-- <button class="btn btn-primary">Follow</button> --}}
                            
                              <a href="{{route('dashboard.customers.edit',$data->customers->id)}}" class="btn btn-outline-primary">Edit</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card mt-3">
                      
                        <ul class="list-group list-group-flush">
                         
                          <h6>Social Media Accounts</h6>

                          @foreach ($data->getSocialMediaLinks() as $item)
                         
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                              <h6 class="mb-0"><img style="width: 25px; height:25px;" src="{{ $item->image }}" />{{ $item->title }}</h6>
                              <a target="_blank" href="{{ $item->link }}" class="text-secondary">Show</a>
                            </li>                              
                          @endforeach
                        </ul>
                      </div>
                      
                    </div>
                    <div class="col-md-8">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Basic Info</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">About</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Locations</a>
                        </li>
                      </ul><!-- Tab panes -->
                      <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                          <div class="card mb-3">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Logo</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                    <input type="file" class="form-control" name="logo" />
                                  @else
                                  <a target="_blank" href="{{ $data->logo }}" download>
                                    <img  src="{{ $data->logo }}" alt="Avatar" class="avatar">
                                  </a>
                                 
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                  <input class="form-control" name="store" value="{{ old('store')??$data->store }}" />
                                  @else
                                  {{ $data->store }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                          
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Certificate number</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                  <input class="form-control" name="cr_num" value="{{ old('cr_num')??$data->cr_num }}" />
                                  @else
                                  {{ $data->cr_num }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Vat</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                  <select name="is_vat" class="form-control" aria-label="Default select example">
                                    <option {{ $data->is_vat?'selected':'' }} value="1">Yes</option>
                                    <option {{ !$data->is_vat?'selected':'' }} value="0">No</option>
                                  </select>
                                  @else
                                  {{ $data->is_vat ?'Yes':'No' }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">In Charge Of</h6>
                                </div>
                                <div class="col-sm-9 text-secondary text-uppercase">
                                  @if($editable)
                                  <select name="relation" class="form-control" aria-label="Default select example">
                                    <option {{ $data->relation == 'owner'?'selected':'' }} value="owner">Owner</option>
                                    <option {{ $data->relation == 'employee' ?'selected':'' }} value="employee">Employee</option>
                                    <option {{ $data->relation == 'advertising company' ?'selected':'' }} value="advertising company">Advertising company</option>
                                    <option {{ $data->relation == 'other' ?'selected':'' }} value="other">Other</option>
                                  </select>
                                  @else
                                  {{ $data->relation }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Marouf Number</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                 @if($editable)
                                 <input class="form-control" name="marouf_num" value="{{ old('marouf_num')??$data->marouf_num }}" />
                                 @else
                                 {{ $data->marouf_num }}
                                 @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Type</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                 @if($editable)
                                 <select name="is_vat" class="form-control" aria-label="Default select example">
                                   <option {{ $data->ad_type == 'onsite'?'selected':'' }} value="onsite">Onsite</option>
                                   <option {{ !$data->ad_type == 'online' ?'selected':'' }} value="online">Online</option>
                                 </select>
                                 @else
                                 {{ $data->ad_type }}
                                 @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Budget</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                 <input class="form-control" name="budget" value="{{ old('budget')??$data->budget }}" />
                                 @else
                                 {{ $data->budget }}
                                 @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-12">
                                  @if($editable)
                                  <a class="btn btn-info " onclick="mainForm()" type="button">Update</a>
                                  @else
                                  <a class="btn btn-info "  href="{{ route('dashboard.ads.edit',[$data->id,'test']) }}">Edit</a>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                          <div class="card mb-3">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Goal</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  
                                  @if($editable)
                                  <select name="is_vat" class="form-control" aria-label="Default select example">
                                    <option {{ $data->is_vat?'selected':'' }} value="1">Yes</option>
                                    <option {{ !$data->is_vat?'selected':'' }} value="0">No</option>
                                  </select>
                                  @else
                                  {{ $data->campaignGoals->title }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">About</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                  <textarea rows="7" class="form-control" name="about">
                                    {{ $data->about }}
                                  </textarea>
                                  @else
                                  {{ $data->about }}
                                  @endif
                                  
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">About Product</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                 @if($editable)
                                  <textarea rows="7" class="form-control" name="about_product">
                                    {{ $data->about_product }}
                                  </textarea>
                                  @else
                                  {{ $data->about_product }}
                                  @endif
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Social Media</h6>
                                </div>
                                <div class="col-sm-9 text-secondary text-uppercase">
                             
                                  <img style="width: 20px; height:20px;" src="{{ count($data->socialMediasAccount) > 0 ? $data->socialMediasAccount[0]->image:null }}" />
                                
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Link</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  @if($editable)
                                  <input class="form-control" name="store_link" value="{{ old('store_link')??$data->store_link }}" />

                                  @else
                                  <a class="btn btn-secondary" target="_blank" href="{{ $data->store_link }}"><i class="bx bx-bullseye"></i></a> 
                                  @endif

                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-12">
                                  @if($editable)
                                  <button type="button" onclick="mainForm()" class="btn btn-info">Update</a>
                                    @else
                                    <a class="btn btn-info "  href="{{ route('dashboard.ads.edit',[$data->id,'test']) }}">Edit</a>
                                  @endif
                                  {{-- <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a> --}}

                                  {{-- <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a> --}}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                          <div class="card mb-3">
                            <div class="card-body">
                              @foreach ($data->storeLocations as $key=>$item)
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Info:</h6>
                                  </div>
                                  <div class="col-sm-7 text-secondary">
                                    {{ $item->countries->name }} {{ $item->cities->name }} {{ $item->areas->name }}
                                  </div>
                                  <div class="col-sm-1 text-secondary">
                                   <button class="btn btn-secondary" type="button" onclick="setEditValue()" class="btn btn-edit">Edit</button>
                                  </div>
                                </div>
                                <hr>
                              @endforeach
                               
                            </div>

                            <div id="addressSection">
                              <h5>
                                Change Address
                              </h5>
                              <hr/>
                              <div class="row">
                                <div class="col-4">
                                  <select onchange="getAreas(event.target.value)" class="form-control" name="" id="selectCountryS">
                                    @foreach ($countries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div id="selectArea" class="col-4">
                                  <input disabled class="form-control" type="text"/>
                                </div>
                                <div id="selectCity" class="col-4">
                                  <input disabled class="form-control" type="text"/>
                                </div>
                                <div class="col mt-2">
                                  <button type="button" onclick="updateAddress('{{ $data->id }}')" class="btn btn-secondary float-right">Change</button>
  
                                </div>
                                
                              </div>

                            </div>

                          </div>
                        </div>
                      </div>
                   
        
                      <div class="row gutters-sm">
                        <div class="col-sm-6 mb-3">
                          <div class="card h-100">
                            <div class="card-body">
                              <h6 class="d-flex align-items-center mb-3"><button onclick="addVideoModal(1)" type="button" class="btn btn-info material-icons text-white mr-2">Add</button>Image</h6>
                              <ul class="list-group text-white w-100">
                                @foreach ($data->image as $key => $item)
                                
                                <li class="list-group-item d-flex justify-content-between align-content-center ">
                                    <div class="d-flex flex-row"> <img src="{{ asset('img/icons/misc/jpg.png') }}" width="40" />
                                        <div class="ml-2">
                                            <h6 class="mb-0">Image #{{ $key+1 }}</h6>
                                          
                                            <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                        </div>
                                    </div>
                                    <div class="check"><a class="" target="_blank" href="{{ $item->url }}">Show</i></a></div>
                                </li>
                                @endforeach
                          
                            </ul>
                
                             
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="card h-100">
                            <div class="card-body">
                              <h6 class="d-flex align-items-center mb-3"><button onclick="addVideoModal()" type="button" class="btn btn-info material-icons text-white mr-2">Add</button>Videos</h6>
                              <div class="row">
                                <ul class="list-group text-white w-100">
                                  @foreach ($data->videos as $key => $item)
                               
                                  <li class="list-group-item d-flex justify-content-between align-content-center ">
                                      <div class="d-flex flex-row"> <img src="{{ asset('img/icons/misc/folderIcon.png') }}" width="40" />
                                          <div class="ml-2">
                                              <h6 class="mb-0">Video #{{ $key+1 }}</h6>
                                              <div class="about"><button onclick="deleteFileModal( {{$item->id}})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                              {{-- <div class="about"> <span>22 Files</span> <span>Jan 21, 2020</span> </div> --}}
                                          </div>
                                      </div>
                                      <div class="check"> <a target="_blank" href="{{ $item->url }}">Show</a></div>
                                  </li>
                                  @endforeach
                            
                              </ul>
                                {{-- <ul>
                                  @foreach ($data->videos as $key => $item)
                                  <li>
                                    Video #{{ $key+1 }} (<a href="{{ $item }}" target="_blank">Show!</a>)
                                  </li>
                                  @endforeach
                                  --}}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
        
                </div>
            </div>

            {{-- @if ($data->document)
            <div class="form-group">
              <label class="col mb-2" for="inputAddress2">document</label>
           
              @foreach ($data->document as $item)
              <a target="_blank" download href="{{ $item->url }}">
                <img src="{{ $item->url }}" />
              </a>
                  
              @endforeach
             
            </div>
                
            @endif --}}
          
        

          
            

            <div class="form-group">
              <label for="inputAddress2">Status</label>
              @if($data->status == 'pending'||$data->status == 'rejected')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option {{ $data->status == 'approve'?'selected':'' }} value="approve">Approve</option>
               
              </select>
              @elseif($data->status == 'approve'||$data->status == 'prepay'||$data->status == 'fullpayment')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option disabled {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option disabled {{ $data->status == 'approve'?'selected':'' }} value="approve">Approve</option>
                <option disabled {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
            
              </select>
              @else
             
              <select id="status" class="form-control" id="exampleFormControlSelect1">
          
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
          <hr/>
            @if(count($matches) > 0)
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
                                    <img  class="img-fluid inf-image" src="{{ $item->influencers->users->infulncerImage?$item->influencers->users->infulncerImage['url']:null }}" alt="">
                                  </div>
                                </td>

                                {{-- @php
                                  dd($item->influencers->checkIfAccepted($data->id));    
                                @endphp --}}
                                  <td>{{  $item->influencers->first_name }} {{  $item->influencers->middle_name }} {{  $item->influencers->last_name }}</td>
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
                                    <button type="button" onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')" class="btn btn-secondary">
                                      <i class="bx bx-transfer"></i>
                                     </button> 

                                   
                                  </td>
                              </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
            @endif
      </div>
    
           

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
                                      {{-- @if ($item->influencers->users->infulncerImage)
                                      @php
                                          dd($item->influencers->users->infulncerImage['url']);
                                      @endphp
                                          
                                      @endif --}}
                                      <img class="img-fluid" src="{{ $item->influencers->users->infulncerImage?$item->influencers->users->infulncerImage['url']:null }}" alt="">
                                    </div>
                                    <div class="candidate-list-details">
                                      <div class="candidate-list-info">
                                        <div class="candidate-list-title">
                                          <h5 class="mb-0">{{  $item->influencers->first_name }} {{  $item->influencers->middle_name }} {{  $item->influencers->last_name }}</h5>
                                          <span style="font-size:12px;">{{ $item->match }}%</span><br/>
                                          {{-- <a href="#" class="text-info float-right" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a> --}}
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
              <div class="modal-header">
                <h5 class="modal-title">Deleteing Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3 id="addFileIcon" class="text-center mt-4" ><i class="bx bx-trash"></i></h3>
                <h3 id="addFileModalTitle" class="text-center">Delete</h3>
                <p class="text-center">After Deleteing this file you will not be able to restore it</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="deleteFile()" type="button" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>

        </section>
</div>



@endsection
@section('scripts')
<script>
    $('#addressSection').hide();

const Toast = Swal.mixin({
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

  var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
var yyyy = today.getFullYear();
let choosen_inf_id = 0;
let showAddress = false;

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
        // ad_type:document.getElementById('ad_type').value,
        onSite:'{{ $data->onSite }}',
        adBudget:'{{ $data->budget }}',
        // expense_type:document.getElementById('expense_type').value,
        _token:'{{csrf_token()}}'
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
        date:document.getElementById('contractDate').value
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
            location.reload();
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
