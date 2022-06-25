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
                    <p class="mb-0">Update Ad</p>
                </div>
                <hr class="w-100">
            </div>

            <div class="col">
                <form enctype="multipart/form-data" action="{{ route('dashboard.ads.update_info_submit',$data->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-1">
                            <label for="exampleFormControlInput1" class="form-label">Trade Mark Name</label>
                            <input  name="store" value="{{ old('store')?old('store'):$data->store }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                          </div>
                          <div class="col-6 mb-1">
                            <label for="exampleFormControlInput1" class="form-label">Cr Number</label>
                            <input name="cr_number" value="{{ old('cr_num')?old('cr_num'):$data->cr_num }}" type="number" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                          </div>
                    </div>
                  <div class="row">
                    <div class="mb-1 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Marouf Number</label>
                        <input row name="marouf_num" value="{{ old('marouf_num')?old('marouf_num'):$data->marouf_num }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                      </div>
                 
                      <div class="mb-1 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Budget</label>
                        <input  name="budget" value="{{ old('budget')?old('budget'):$data->budget }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                      </div>
                  </div>
                  <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">About</label>
                    <textarea  rows="6" name="about" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">{{ old('about')?old('about'):$data->about }}</textarea>
                  </div>
                
                  <div class="row">
                    <div class="mb-1 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Tax Number</label>
                        <input name="tax_value" value="{{ old('tax_value')?old('tax_value'):$data->tax_value }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                      </div>
                      <div class="mb-1 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Link</label>
                        <input  name="store_link" value="{{ old('store_link')?old('store_link'):$data->store_link }}" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">
                      </div>
                  </div>

                  <div class="row">
                    <div class="mb-1 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Relation</label>
                        <select name="relation_id" class="form-control" aria-label="Default select example">
                            @foreach ($realations as $item)
                            <option {{ $data->relation_id == $item->id?'selected':'' }} value="owner">{{ $item->title }}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="mb-1 col-6">
                        <label for="formFile" class="form-label">Logo</label>
                        <input name="logo" class="form-control" type="file" id="formFile">                      
                      </div>
                  </div>
                 
                 
                  <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">About product</label>
                    <textarea  rows="6" name="about_product" type="text" class="form-control" id="exampleFormControlInput1" placeholder="add trade mark">{{ old('about_product')?old('about_product'):$data->about_product }}</textarea>
                  </div>
                 
                  <label for="country_id">Location</label>
                  <hr>
                  <div class="row">
                    <div class="col-4 mb-1">
                        <label for="country_id">Country</label>
                        <select name="country_id" id="country_id" class="form-control required">
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}" {{ $data->country_id == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 mb-1">
                        <label for="region_id">Region</label>
                        <select name="region_id" id="region_id" class="form-control required" data-value="{{ $data->region_id }}"></select>
                    </div>
                    <div class="col-4 mb-1">
                        <label for="city_id">City</label>
                        <select name="city_id" id="city_id" class="form-control required" data-value="{{ $data->city_id }}"></select>
                    </div>
                  </div>
                  <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">Campaign Goals</label>
                    <select name="campaign_goals_id" class="form-control" aria-label="Default select example">
                        @foreach ($goals as $item)
                        <option {{ $item->campaign_goals_id == $item->id?'selected':'' }} value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                      </select>
                  </div>
                {{-- <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">Social Medias</label>
                    <select name="social_media_id" class="form-control" aria-label="Default select example">
                        @foreach ($socialMedias as $item)
                        <option {{ $item->social_media_id == $item->id?'selected':'' }} value="owner">{{ $item->name }}</option>
                        @endforeach
                      </select>
                  </div> --}}
                 
            
                  <div class="mb-1 col mt-1">
                    <label for="exampleFormControlInput1" class="form-label">is Vat</label>
                    <div class="form-check">
                      <input name="is_vat" class="form-check-input" type="checkbox" value="{{ old('is_vat')?old('is_vat'):$data->is_vat }}" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                            Yes
                      </label>
                     </div>
                    </div>
            </div>
            <div class="col mt-2 mb-2">
                <button class="btn btn-primary float-right" type="submit">Update</button>
            </div>
        </form>

          </div>
      </section>
  </div>

@section('scripts')
<script>
    $('#country_id').on('change',function() {
              $('#region_id').html('');
              var route = '{{ route("regions.getRegion",":country"); }}';
              route = route.replace(':country',$(this).val());
              $.get(route,function(res) {
                  if(res.status == 200){
                      let options = ``;
                      let value = $('region_id').attr('data-value');
                      res.data.forEach((item, index)=>{
                          options += `<option value="${item.id}" ${ value == item.id ? 'selected' : '' }>${item.name.en}</option>`;
                      });
                      $('#region_id').html(options).change();
                  }
              },'json');
          }).change();

          $('#region_id').on('change',function() {
              $('#city_id,#rep_city').html('');
              var route = '{{ route("cities.getCities",":city"); }}';
              route = route.replace(':city',$(this).val());
              $.get(route,function(res) {
                  if(res.status == 200){
                      let options = ``;
                      let optionsDelivery = ``;
                      let value = $('#city_id').attr('data-value');
                      let valueDelivert = $('#rep_city').attr('data-value');
                      res.data.forEach((item, index)=>{
                          options += `<option value="${item.id}" ${ value == item.id ? 'selected' : '' }>${item.name}</option>`;
                          optionsDelivery += `<option value="${item.id}" ${ valueDelivert == item.id ? 'selected' : '' }>${item.name}</option>`;
                      });
                      $('#city_id').html(options);
                      $('#rep_city').html(optionsDelivery);
                  }
              },'json');
          });
</script>
@endsection

  
@endsection


