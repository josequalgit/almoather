@extends('dashboard.layout.index')
@section('content')
<style>
  .profileImage{
    width:150px;
  }
  .video{
    margin: 2%;
  }
</style>
<div class="app-content content p-5 mt-5">
  <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.edit',$data->id) }}">

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"><i class="menu-icon tf-icons bx bx-user"></i> Personal</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"><i class="menu-icon tf-icons bx bx-building"></i> Media Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab"><i class="menu-icon tf-icons bx bx-package"></i> Delivery Information</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"><i class="menu-icon tf-icons bx bx-money"></i> Billing</a>
    </li>
  </ul><!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane active" id="tabs-1" role="tabpanel">
      
      <section id="basic-input">
        <div class="card p-5">
          @if($errors->any())
          <div class="alert alert-danger" role="alert"> There is something wrong
              @foreach ($errors->all() as $error )
                  <li>{{$error}}</li>
              @endforeach
          </div>
          @endif
           @csrf
           @if($data->users->infulncerImage)
            <div class="form-row mb-2">
              <div class="form-group col-md-6">
                <img class="profileImage" src="{{ $data->users->infulncerImage ? $data->users->infulncerImage['url'] :null }}"/>
              </div>
            </div>
            @endif
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Name</label>
                @php
                  $fullName = $data->first_name.' '.$data->middle_name.' '.$data->last_name    
                @endphp
                <input disabled value="{{ old('full_name_en')?old('full_name_en'):$fullName}}" name="full_name_en" type="full_name" class="form-control" id="inputfull_name_en4" placeholder="full_name_en">
              </div>
              {{-- <div class="form-group col-md-6">
                <label for="inputPassword4">Nick Name</label>
                <input disabled value="{{ old('nick_name')?old('nick_name'):$data->nick_name}}" name="nick_name" type="text" class="form-control" id="inputnick_name4" placeholder="nick_name">
              </div> --}}
              <div class="form-group col">
                <label for="inputPassword4">Gender</label>
                <input disabled value="{{ old('gender')?old('gender'):$data->gender}}" name="gender" type="text" class="form-control" id="inputgender4" placeholder="gender">
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress2">Nationality</label>
              <input disabled value="{{ old('nationality_id')?old('nationality_id'):$data->nationalities->name}}" name="nationality_id" type="text" class="form-control" id="inputAddress2" placeholder="nationality_id">
            </div>
           
            {{-- <div class="form-group">
              <label for="inputAddress2">Bank Name</label>
              <input disabled value="{{ old('bank_name')?old('bank_name'):$data->bank_name}}" name="bank_name" type="text" class="form-control" id="inputAddress2" placeholder="bank_name">
            </div> --}}
            {{-- <div class="form-group">
              <label for="inputAddress2">Birth Day</label>
              <input disabled value="{{ old('birthday')?old('birthday'):$data->birthday}}" name="birthday" type="text" class="form-control" id="inputAddress2" placeholder="birthday">
            </div> --}}
            <div class="form-group">
              <label for="inputAddress2">Id Number</label>
              <input disabled value="{{ old('id_number')?old('id_number'):$data->id_number}}" name="id_number" type="text" class="form-control" id="inputAddress2" placeholder="birthday">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Country</label>
              <input disabled value="{{ old('country_id')?old('country_id'):$data->countries->name}}" name="country_id" type="text" class="form-control" id="inputAddress2" placeholder="country_id">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Region</label>
              <input disabled value="{{ old('region_id')?old('region_id'):$data->regions->name}}" name="region_id" type="text" class="form-control" id="inputAddress2" placeholder="region_id">
            </div>
            <div class="form-group">
              <label for="inputAddress2">City</label>
              <input disabled value="{{ old('city_id')?old('city_id'):$data->citys->name}}" name="city_id" type="text" class="form-control" id="inputAddress2" placeholder="city_id">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Email</label>
              <input disabled value="{{ old('email')?old('email'):$data->users->email}}" name="email" type="text" class="form-control" id="inputAddress2" placeholder="email">
            </div>
           
            <div class="form-group">
              <label for="inputAddress2">Phone</label>
              <input disabled value="{{ old('phone')?old('phone'):$data->users->phone}}" name="phone" type="text" class="form-control" id="inputAddress2" placeholder="birthday">
            </div>
         
            
            {{-- <div class="form-group">
              <label for="inputAddress2">Bio</label>
              <textarea class="form-control" disabled>{{ old('bio')?old('bio'):$data->bio}}</textarea>
            </div> --}}
            {{-- <div class="form-group">
              <label for="inputAddress2">Ads Out if Country</label>
              <input disabled value="{{$data->ads_out_country?'Yes':'No'}}" name="ads_out_country" type="text" class="form-control" id="inputAddress2" placeholder="ads_out_country">
            </div>
            <div class="form-group">
              <label for="inputAddress2">Is Vat</label>
              <input disabled value="{{$data->is_vat?'Yes':'No'}}" name="is_vat" type="text" class="form-control" id="inputAddress2" placeholder="is_vat">
            </div> --}}
            <div class="form-group">
              <label for="inputAddress2">Ratting</label>
              <input disabled value="{{ old('ratting')?old('ratting'):$data->ratting}}" name="ratting" type="text" class="form-control" id="inputAddress2" placeholder="ratting">
            </div>
           
            
            {{-- <div class="form-group">
              <label for="inputAddress2">Snap Chat Views</label>
              <input disabled value="{{ old('snap_chat_views')?old('snap_chat_views'):$data->snap_chat_views}}" name="snap_chat_views" type="text" class="form-control" id="inputAddress2" placeholder="ad_onsite_price_with_vat">
            </div> --}}
          
           
         
            
        

            {{-- <div class="form-group">
              <label for="inputAddress2">Category</label>
              <input disabled value="{{ old('nationality_id')?old('nationality_id'):$data->nationalities->name}}" name="nationality_id" type="text" class="form-control" id="inputAddress2" placeholder="nationality_id">
            </div> --}}


            @if($data->users->snapChatVideo)
            <label for="inputAddress2 mt-2">Snap Chat Videos</label>
            <div class="form-row mb-2">
              <div class="form-group col row">
                @foreach ($data->users->snapChatVideo as $item)
                <div class="video">
                  <video  width="320" height="240" controls>
                    <source src="{{ $item ? $item['url'] :null }}" type="video/mp4">
                  Your browser does not support the video tag.
                  </video>

                </div>
                @endforeach
              </div>
            </div>
            @endif

            @if($data->videos)
            <label for="inputAddress2 mt-2">Videos</label>
            <div class="form-row mb-2">
              <div class="form-group col row">
                @foreach ($data->videos as $item)
                <div class="video">
                  <video  width="320" height="240" controls>
                    <source src="{{ $item ? $item :null }}" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>

                </div>
                @endforeach
              </div>
            </div>
            @endif

            @if($data->rejected_note)
            <div class="form-group">
              <label for="inputAddress2">Rejected Note</label>
              <textarea class="form-control" rows="12" disabled>{{ old('rejected_note')?old('rejected_note'):$data->rejected_note}}</textarea>
            </div>
            @endif
            
            <div class="form-group">
              <label for="inputAddress2">Categories</label>
              {{-- <select class="form-control" id="exampleFormControlSelect1">
                
                @foreach ($data->InfluncerCategories as $item)
                <option  selected disabled value="{{ $item->id }}">{{ $item->name }}</option>                    
                @endforeach
              </select> --}}
              <div class="input-group mt-2">
                <div class="input-group-prepend">
                  @foreach ($categories as $item)
                  {{-- <button class="btn btn-outline-primary" type="button">{{ $item->name }}</button> --}}
                  <div class="form-check form-check-inline">
                    <input class="check_class" name="categories[]" {{ in_array($item->id, $infCategories)?'checked':'' }} class="form-check-input" type="checkbox" id="inlineCheckbox{{ $item->id }}" value="{{ $item->id }}">
                    <label class="form-check-label pl-1" for="inlineCheckbox{{ $item->id }}">  {{ $item->name }}  </label>
                  </div>
                  @endforeach
                </div>
                {{-- <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1"> --}}

               
              
                
              </div>
              
            </div>
            <div class="form-group">
              <label for="inputAddress2">Status</label>
              <select id="status" class="form-control" id="exampleFormControlSelect1">
                <option {{ $data->status == 'pending'?'selected':'' }} disabled value="pending">Pending</option>
                <option {{ $data->status == 'accepted'?'selected':'' }} value="accepted">Accepted</option>
                <option {{ $data->status == 'rejected'?'selected':'' }} value="rejected">Rejected</option>
                <option {{ $data->status == 'band'?'selected':'' }} value="band">Band</option>
              </select>
            
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
   
        </section>


    </div>
    <div class="tab-pane" id="tabs-2" role="tabpanel">
      <div class="card p-5">
            <section id='basic-input'>
              {{-- <div class="form-group">
                <label for="inputAddress2">Milestone</label>
                <input disabled value="{{ old('milestone')?old('milestone'):$data->milestone}}" name="milestone" type="text" class="form-control" id="inputAddress2" placeholder="milestone">
              </div> --}}
              <div class="form-group">
                <label for="inputAddress2">Nick Name</label>
                <input disabled value="{{ old('nick_name')?old('nick_name'):$data->nick_name}}" name="nick_name" type="text" class="form-control" id="inputAddress2" placeholder="nick_name">
              </div>
              {{-- <div class="form-group">
                <label for="inputAddress2">Street</label>
                <input disabled value="{{ old('street')?old('street'):$data->street}}" name="street" type="text" class="form-control" id="inputAddress2" placeholder="street">
              </div> --}}
              <div class="form-group">
                <label for="inputAddress2">About Me</label>
                <textarea class="form-control" disabled>{{ old('bio')?old('bio'):$data->bio}}</textarea>
              </div>
              <div class="form-group">
                <label for="inputAddress2">Is Out Country</label>
                <input disabled value="{{ $data->ads_out_country?'Yes':'No'}}" name="ads_out_country" type="text" class="form-control" id="inputAddress2" placeholder="ads_out_country">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Online price</label>
                <input disabled value="{{ old('ad_price')?old('ad_price'):$data->ad_price}}" name="ad_price" type="text" class="form-control" id="inputAddress2" placeholder="ad_price">
              </div>

              <div class="form-group">
                <label for="inputAddress2">Onsite price</label>
                <input disabled value="{{ old('ad_onsite_price')?old('ad_onsite_price'):$data->ad_onsite_price}}" name="ad_onsite_price" type="text" class="form-control" id="inputAddress2" placeholder="ad_onsite_price">
              </div>

              <div class="form-group">
                <label for="inputAddress2">Online price with vat</label>
                <input disabled value="{{ old('ad_with_vat')?old('ad_with_vat'):$data->ad_with_vat}}" name="ad_with_vat" type="text" class="form-control" id="inputAddress2" placeholder="ad_with_vat">
              </div>

              <div class="form-group">
                <label for="inputAddress2">Onsite price with vat</label>
                <input disabled value="{{ old('ad_onsite_price_with_vat')?old('ad_onsite_price_with_vat'):$data->ad_onsite_price_with_vat}}" name="ad_onsite_price_with_vat" type="text" class="form-control" id="inputAddress2" placeholder="ad_onsite_price_with_vat">
              </div>

              
             
              <div class="form-group">
                <label class="mb-2" for="inputAddress2">Social Media</label>
                <div class="row pl-1">
                  @foreach ($data->socialMediaProfiles as $item)
                  <div>
                    <img src="{{ $item->socialMedias->image }}" class="rounded-circle" style="width: 50px;"
                    alt="Avatar" />
                    <p class="text-center mt-1"><a target="_blank" href="{{ $item->link }}">Show</a></p>
                  </div>
                  @endforeach
                </div>
              </div>
              {{-- <div class="form-group">
                <label for="inputAddress2">Neighborhood</label>
                <input disabled value="{{ old('neighborhood')?old('neighborhood'):$data->neighborhood}}" name="neighborhood" type="text" class="form-control" id="inputAddress2" placeholder="neighborhood">
              </div> --}}
              {{-- <div class="form-group">
                <label for="inputAddress2">City</label>
                <input disabled value="{{ old('city_id')?old('city_id'):$data->citys->name}}" name="city_id" type="text" class="form-control" id="inputAddress2" placeholder="city_id">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Country</label>
                <input disabled value="{{ old('country_id')?old('country_id'):$data->countries->name}}" name="country_id" type="text" class="form-control" id="inputAddress2" placeholder="country_id">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Region</label>
                <input disabled value="{{ old('region_id')?old('region_id'):$data->regions->name}}" name="region_id" type="text" class="form-control" id="inputAddress2" placeholder="region_id">
              </div> --}}
            </section>
      </div>
    </div>
    <div class="tab-pane" id="tabs-3" role="tabpanel">
      <div class="card p-5">
        <section id="basic-input">
          <div class="form-group">
            <label for="inputAddress2">Bank Account Name</label>
            <input disabled value="{{ old('bank_account_name')?old('bank_account_name'):$data->bank_account_name}}" name="bank_account_name" type="text" class="form-control" id="inputAddress2" placeholder="bank_account_name">
          </div>
            <div class="form-group">
                <label for="inputAddress2">Bank Name</label>
                <input disabled value="{{ old('bank_name')?old('bank_name'):$data->banks->name}}" name="bank_name" type="text" class="form-control" id="inputAddress2" placeholder="bank_name">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Bank Account Number</label>
                <input disabled value="{{ old('bank_account_number')?old('bank_account_number'):$data->bank_account_number}}" name="bank_account_number" type="text" class="form-control" id="inputAddress2" placeholder="bank_account_number">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Commercial Registration No</label>
                <input disabled value="{{ old('commercial_registration_no')?old('commercial_registration_no'):$data->commercial_registration_no}}" name="commercial_registration_no" type="text" class="form-control" id="inputAddress2" placeholder="commercial_registration_no">
              </div>
              @if ($data->commercialFiles)
              <div class="form-group">
                <label for="inputAddress2">Commercial Registration Files</label>
                <br/>
                <a target="_blink" class="btn btn-secondary" href="{{ $data->commercialFiles['url'] }}" download>
                  Download
                </a>                
              </div>
                  
              @endif
              <div class="form-group">
                <label for="inputAddress2">Tax Registration Number</label>
                <input disabled value="{{ old('tax_registration_number')?old('tax_registration_number'):$data->tax_registration_number}}" name="tax_registration_number" type="text" class="form-control" id="inputAddress2" placeholder="tax_registration_number">
              </div>
              {{-- <div class="form-group">
                <label for="inputAddress2">Ad Price</label>
                <input disabled value="{{ old('ad_price')?old('ad_price'):$data->ad_price}}" name="ad_price" type="text" class="form-control" id="inputAddress2" placeholder="ad_price">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Is Ad With Vat</label>
                <input disabled value="{{ old('ad_with_vat')?old('ad_with_vat'):$data->ad_with_vat}}" name="ad_with_vat" type="text" class="form-control" id="inputAddress2" placeholder="ad_with_vat">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Onsite Ad Price</label>
                <input disabled value="{{ old('ad_onsite_price')?old('ad_onsite_price'):$data->ad_onsite_price}}" name="ad_onsite_price" type="text" class="form-control" id="inputAddress2" placeholder="ad_onsite_price">
              </div>
              <div class="form-group">
                <label for="inputAddress2">Onsite Ad Price With Vat</label>
                <input disabled value="{{ old('ad_onsite_price_with_vat')?old('ad_onsite_price_with_vat'):$data->ad_onsite_price_with_vat}}" name="ad_onsite_price_with_vat" type="text" class="form-control" id="inputAddress2" placeholder="ad_onsite_price_with_vat">
              </div> --}}
             
            
              
              @if ($data->taxFiles)
                <div class="form-group">
                  <label for="inputAddress2">Tax Files</label>
                  <br/>
                  <a target="_blink" class="btn btn-secondary" href="{{ $data->taxFiles['url'] }}" download>
                    Download
                  </a>                
                </div>
                  
              @endif
  
        </section>
      </div>
    </div>
    <div class="tab-pane" id="tabs-4" role="tabpanel">
      <div class="card p-5">
        <section id="basic-input">
          <div class="form-group">
            @php
            $repFullName = $data->rep_full_name;
            @endphp
            <label for="inputAddress2">Full Name</label>
            <input disabled value="{{ old('rep_full_name')?old('rep_full_name'):$repFullName}}" name="rep_full_name" type="text" class="form-control" id="inputAddress2" placeholder="rep_full_name">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Phone Number</label>
            <input disabled value="{{ old('rep_phone_number')?old('rep_phone_number'):$data->rep_phone_number}}" name="rep_phone_number" type="text" class="form-control" id="inputAddress2" placeholder="rep_phone_number">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Region</label>
            <input disabled value="{{ old('region_id')?old('region_id'):$data->regions->name}}" name="region_id" type="text" class="form-control" id="inputAddress2" placeholder="region_id">
          </div> 
          <div class="form-group">
            <label for="inputAddress2">City</label>
            <input disabled value="{{ old('rep_city')?old('rep_city'):$data->rep_city}}" name="rep_city" type="text" class="form-control" id="inputAddress2" placeholder="rep_city">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Area</label>
            <input disabled value="{{ old('rep_area')?old('rep_area'):$data->rep_area}}" name="rep_area" type="text" class="form-control" id="inputAddress2" placeholder="rep_area">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Street</label>
            <input disabled value="{{ old('rep_street')?old('rep_street'):$data->rep_street}}" name="rep_street" type="text" class="form-control" id="inputAddress2" placeholder="rep_street">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Milestone</label>
            <input disabled value="{{ old('milestone')?old('milestone'):$data->milestone}}" name="milestone" type="text" class="form-control" id="inputAddress2" placeholder="milestone">
          </div>
          {{-- <div class="form-group">
            <label for="inputAddress2">Location</label>
            <input disabled value="{{ $data->rep_city.' '.$data->rep_area.' '.$data->rep_street}}" name="rep_id_number_name" type="text" class="form-control" id="inputAddress2" placeholder="rep_id_number_name">
          </div>
          --}}
            
        </section>
      </div>
    </div>
  </div>
   
  @can('Edit Influncer')
              <button onclick="changeStatus()" type="button" class="mt-2 btn btn-primary float-right">Change</button> 
              @endcan     
</form>

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
    var cate=[];
      $('input[name="categories[]"]:checked').each(function () {
        cate[cate.length] = (this.checked ? $(this).val() : "");
      });
    let url  = '{{ route("dashboard.influncers.updateStatus",":id") }}';
    let urlWithId = url.replace(':id','{{ $data->id }}');
    $.ajax({
      url:urlWithId,
      type:'POST',
      data:{
        status:document.getElementById('status').value,
        note:document.getElementById('rejectedNote').value,
        categories:cate
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
