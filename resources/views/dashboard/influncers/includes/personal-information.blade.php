<h3>Personal Information</h3>
<section id="basic-input">
    <div class="card mb-0">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert"> There is something wrong
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif
        @csrf
        
        <div class="row">
            
            @if ($data->status == 'rejected')
                <div class="form-group col-12">
                    <label for="inputAddress2">Rejected Note</label>
                    <textarea class="form-control" rows="12" disabled>{{ old('rejected_note') ? old('rejected_note') : $data->rejected_note }}</textarea>
                </div>
            @endif
            @if ($data->users->infulncerImage)
                <fieldset class="form-group col-md-6">
                                        
                    <div class="imgUp">
                        <img class="image-preview"  src="{{ $data->users->infulncerImage['url'] }}" />
                        <label class="btn btn-primary">
                            Upload<input name="image" type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                    </div>
                    
                </fieldset>
            @endif
            <div class="col-6"></div>
            <div class="form-group col-md-6">
                <label for="first-name">First Name</label>
                <input value="{{ old('first_name') ? old('first_name') : $data->first_name }}" name="first_name"
                    type="text" class="form-control required" id="first-name" placeholder="First Name">
            </div>
            <div class="form-group col-md-6">
                <label for="first-name">Middle Name</label>
                <input value="{{ old('middle_name') ? old('middle_name') : $data->middle_name }}" name="middle_name"
                    type="text" class="form-control required" id="middle-name" placeholder="Middle Name">
            </div>
            <div class="form-group col-md-6">
                <label for="first-name">Last Name</label>
                <input value="{{ old('last_name') ? old('last_name') : $data->last_name }}" name="last_name"
                    type="text" class="form-control required" id="last-name" placeholder="Last Name">
            </div>
            <div class="form-group col-md-6">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control required">
                    <option value="male" {{ $data->gender == 'male' }}>Male</option>
                    <option value="female" {{ $data->gender == 'female' }}>Female</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="nationality_id">Nationality</label>
                <select name="nationality_id" id="nationality_id" class="form-control required">
                    @foreach ($nationalities as $nationality)
                        <option value="{{$data->nationality_id}}" {{ $data->nationality_id == $nationality->id ? 'selected' : ''}}>{{$nationality->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="id_number">Id Number</label>
                <input value="{{ old('id_number') ? old('id_number') : $data->id_number }}" name="id_number"
                    type="text" class="form-control required" id="id_number" placeholder="birthday">
            </div>
            <div class="form-group col-md-6">
                <label for="country_id">Country</label>
                <select name="country_id" id="country_id" class="form-control required">
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}" {{ $data->country_id == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="region_id">Region</label>
                <select name="region_id" id="region_id" class="form-control required" data-value="{{ $data->region_id }}"></select>
            </div>
            <div class="form-group col-md-6">
                <label for="city_id">City</label>
                <select name="city_id" id="city_id" class="form-control required" data-value="{{ $data->city_id }}"></select>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input value="{{ old('email') ? old('email') : $data->users->email }}" disabled type="text"
                    class="form-control" id="email" placeholder="email">
            </div>

            <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input value="{{ $data->users->dial_code . $data->users->phone }}" disabled type="text"
                    class="form-control required" id="phone" placeholder="Phone">
            </div>
            

            @if ($data->videos)
            <div class="form-group col-12">
                <label for="video mt-2">Videos</label>
                <div class="form-row mb-2">
                    <div class="form-group col row">
                        @foreach ($data->videos as $item)
                            <div class="video">
                                <video width="320" height="240" controls>
                                    <source src="{{ $item ? $item : null }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
</section>