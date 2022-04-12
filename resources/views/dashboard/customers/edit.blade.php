@extends('dashboard.layout.index')
@section('content')
<style>
   .profileImage{
    width:150px;
  }
</style>
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
           @if($data->users->image)
           <div class="form-row mb-2">
             <div class="form-group col-md-6">
               <img class="profileImage" src="{{ $data->users->image ? $data->users->image['url'] :null }}"/>
             </div>
           </div>
           @endif
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">First Name</label>
                <input disabled value="{{ old('first_name')?old('first_name'):$data->first_name}}" name="first_name" type="full_name" class="form-control" id="inputfirst_name4" placeholder="first_name">
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Last Name</label>
                <input disabled value="{{ old('last_name')?old('last_name'):$data->last_name}}" name="last_name" type="text" class="form-control" id="inputlast_name4" placeholder="last_name">
              </div>
            </div>
           
            <div class="form-group">
              <label for="inputAddress2">Phone</label>
              <input disabled value="{{ old('phone')?old('phone'):$data->phone}}" name="phone" type="text" class="form-control" id="inputAddress2" placeholder="phone">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Country</label>
              <input disabled value="{{ old('country_id')?old('country_id'):$data->countrys->name}}" name="bank_account_number" type="text" class="form-control" id="inputAddress2" placeholder="bank_account_number">
            </div>
           
            <div class="form-group">
              <label for="inputAddress2">Status</label>
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option {{ $data->status == 'active'?'selected':'' }} value="active">Active</option>
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
        sendStatusRequest();
  }

  function sendStatusRequest()
  {
    let url  = '{{ route("dashboard.customers.updateStatus",":id") }}';
    let urlWithId = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:urlWithId,
      type:'POST',
      data:{
        status:document.getElementById('status').value,
        note:document.getElementById('rejectedNote').value
      },
      success:(res)=>{
        let url = '{{ route("dashboard.customers.index") }}'
        window.location.href = url;
      },
      error:(err)=>{
        alert(err)
      }
    })
  }
</script>
@endsection
