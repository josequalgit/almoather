@extends('dashboard.layout.index')
@section('content')
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
              <input disabled value="{{ old('budget')?old('budget'):$data->customers->first_name.' '.$data->customers->last_name}}" name="budget" type="text" class="form-control" id="inputAddress2" placeholder="budget">
            </div>
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
            @if($data->auth_number)
            <div class="form-group">
              <label for="inputAddress2">Auth Number</label>
              <input disabled value="{{ old('auth_number')?old('auth_number'):$data->auth_number}}" name="auth_number" type="text" class="form-control" id="inputAddress2" placeholder="auth_number">
            </div>
            @endif
            <div class="form-group">
                <label for="inputAddress2">Is Onsite</label>
                <input disabled value="{{ old('onSite')?old('onSite'):($data->onSite?'Yes':'No')}}" name="onSite" type="text" class="form-control" id="inputAddress2" placeholder="onSite">
            </div>
            @if($data->website_link)
            <div class="form-group">
                <label for="inputAddress2">Website Link</label>
                <input disabled value="{{ old('website_link')?old('website_link'):$data->website_link}}" name="website_link" type="text" class="form-control" id="inputAddress2" placeholder="website_link">
            </div>
            @endif
            <div class="form-group">
                <label for="inputAddress2">Social Media</label>
                <input disabled value="{{ old('social_media_id')?old('social_media_id'):$data->socialMedias->name}}" name="social_media_id" type="text" class="form-control" id="inputAddress2" placeholder="social_media_id">
            </div>
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
            @if($data->reject_note)
            <div class="form-group">
                <label for="inputAddress2">Reject Note</label>
                <textarea class="form-control" disabled rows="11">{{ $data->reject_note }}</textarea>
            </div>
            @endif

            <div class="form-group">
              <label class="col mb-2" for="inputAddress2">Image</label>
              <a target="_blank" download href="{{ $data->image }}">
              <img src="{{ $data->image }}" />
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
          
            @if($data->videos)
            <div class="form-group">
              <label class="col mb-2" for="inputAddress2">Videos</label>
              <video class="col" width="320" height="240" controls>
                <source src="{{ $data->videos }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              
            </div>
            @endif


            <div class="form-group">
              <label for="inputAddress2">Status</label>
              @if($data->status == 'pending'||$data->status == 'rejected')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option {{ $data->status == 'waiting_for_payment'?'selected':'' }} value="waiting_for_payment">Waiting For Payment</option>
                <option disabled {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
                <option disabled {{ $data->status == 'fullpayment'?'selected':'' }} value="fullpayment">Full Paymet</option>
                <option disabled {{ $data->status == 'progress'?'selected':'' }} value="progress">Progress</option>
                <option disabled {{ $data->status == 'complete'?'selected':'' }} value="complete">Complete</option>
              </select>
              @elseif($data->status == 'waiting_for_payment'||$data->status == 'prepay'||$data->status == 'fullpayment')
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option disabled {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option disabled {{ $data->status == 'waiting_for_payment'?'selected':'' }} value="waiting_for_payment">Waiting For Payment</option>
                <option disabled {{ $data->status == 'prepay'?'selected':'' }} value="prepay">Pre Pay</option>
                <option disabled {{ $data->status == 'fullpayment'?'selected':'' }} value="fullpayment">Full Paymet</option>
                <option disabled {{ $data->status == 'progress'?'selected':'' }} value="progress">Progress</option>
                <option disabled {{ $data->status == 'complete'?'selected':'' }} value="complete">Complete</option>
              </select>
              @else
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option disabled {{ $data->status == 'pending'?'selected':'' }} value="pending">Pending</option>
                <option disabled {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejecte</option>
                <option disabled {{ $data->status == 'waiting_for_payment'?'selected':'' }} value="waiting_for_payment">Waiting For Payment</option>
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
                <h5 class="modal-title">Expence type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">select</label>
                  <select class="form-control" id="expense_type">
                    <option value="pvn">PVN</option>
                    <option value="pve">PVE</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button>
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
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  function changeStatus()
  {
    let statusValue = document.getElementById('status').value;

    if(statusValue == 'rejected')
    {
        $('#rejectedReson').modal('toggle');

    }
    else
    {
      $('#expensiveType').modal('toggle');

      //  sendStatusRequest();
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
        expense_type:document.getElementById('expense_type').value
      },
      success:(res)=>{
        let url = '{{ route("dashboard.ads.index") }}'
        window.location.href = url;
      },
      error:(err)=>{
       alert('something wrong with updateing the ad');
      }
    })
  }
</script>
@endsection
