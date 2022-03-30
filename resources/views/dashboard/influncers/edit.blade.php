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
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.edit',$data->id) }}">
           @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Name</label>
                <input disabled value="{{ old('full_name_en')?old('full_name_en'):$data->full_name_en}}" name="full_name_en" type="full_name" class="form-control" id="inputfull_name_en4" placeholder="full_name_en">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Nick Name</label>
                <input disabled value="{{ old('nick_name')?old('nick_name'):$data->nick_name}}" name="nick_name" type="text" class="form-control" id="inputnick_name4" placeholder="nick_name">
              </div>
            </div>
           
            <div class="form-group">
              <label for="inputAddress2">Bank Name</label>
              <input disabled value="{{ old('bank_name')?old('bank_name'):$data->bank_name}}" name="bank_name" type="text" class="form-control" id="inputAddress2" placeholder="bank_name">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Bank Account Number</label>
              <input disabled value="{{ old('bank_account_number')?old('bank_account_number'):$data->bank_account_number}}" name="bank_account_number" type="text" class="form-control" id="inputAddress2" placeholder="bank_account_number">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Bio</label>
              <textarea class="form-control" disabled>{{ old('bio')?old('bio'):$data->bio}}</textarea>
            </div>
            <div class="form-group">
              <label for="inputAddress2">City</label>
              <input disabled value="{{ old('city_id')?old('city_id'):$data->citys->name}}" name="city_id" type="text" class="form-control" id="inputAddress2" placeholder="city_id">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Country</label>
              <input disabled value="{{ old('country_id')?old('country_id'):$data->countries->name}}" name="country_id" type="text" class="form-control" id="inputAddress2" placeholder="country_id">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Nationality</label>
              <input disabled value="{{ old('nationality_id')?old('nationality_id'):$data->nationalities->name}}" name="nationality_id" type="text" class="form-control" id="inputAddress2" placeholder="nationality_id">
            </div>

            @if($data->rejected_note)
            <div class="form-group">
              <label for="inputAddress2">Rejected Note</label>
              <textarea class="form-control" rows="12" disabled>{{ old('rejected_note')?old('rejected_note'):$data->rejected_note}}</textarea>
            </div>
            @endif
            <div class="form-group">
              <label for="inputAddress2">Category</label>
              <select class="form-control" id="exampleFormControlSelect1">
                
                @foreach ($data->InfluncerCategories as $item)
                <option  selected disabled value="{{ $item->id }}">{{ $item->name }}</option>                    
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="inputAddress2">Status</label>
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option {{ $data->status == 'pending'?'selected':'' }} disabled value="pending">Pending</option>
                <option {{ $data->status == 'accepted'?'selected':'' }} value="accepted">Accepted</option>
                <option {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejected</option>
                <option {{ $data->status == 'band'?'selected':'' }} value="band">Band</option>
              </select>
              @can('Edit Influncer')
              <button onclick="changeStatus()" type="button" class="mt-2 btn btn-primary float-right">Change</button> 
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
        sendStatusRequest();
      }
  }

  function sendStatusRequest()
  {
    let url  = '{{ route("dashboard.influncers.updateStatus",":id") }}';
    let urlWithId = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:urlWithId,
      type:'POST',
      data:{
        status:document.getElementById('status').value,
        note:document.getElementById('rejectedNote').value
      },
      success:(res)=>{
        let url = '{{ route("dashboard.influncers.index") }}'
        window.location.href = url;
      },
      error:(err)=>{
        alert(err)
      }
    })
  }
</script>
@endsection
