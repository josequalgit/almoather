<h3>Media Information</h3>
<section id='basic-input'>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="nick_name">Nick Name</label>
            <input value="{{ old('nick_name') ? old('nick_name') : $data->nick_name }}" name="nick_name" type="text"
                class="form-control required" id="nick_name" name="nick_name" placeholder="Nick Name">
        </div>
        <div class="form-group col-md-6">
            <label for="bio">About Me</label>
            <textarea id="bio" name="bio" class="form-control required">{{ old('bio') ? old('bio') : $data->bio }}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="ads_out_country">Accept advertisment outside region</label>
            <select name="ads_out_country" id="ads_out_country" class="form-control required">
                <option value="1" {{ $data->ads_out_country ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $data->ads_out_country ? '' : 'selected' }}>No</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="ad_price">Online price excluding vat</label>
            <input value="{{ old('ad_price') ? old('ad_price') : $data->ad_price }}" name="ad_price" type="number" step="0.1"
                class="form-control required" id="ad_price" placeholder="Online price excluding vat" related-input="ad_with_vat" >
        </div>

        <div class="form-group col-md-6">
            <label for="ad_onsite_price">Onsite price excluding vat</label>
            <input value="{{ old('ad_onsite_price') ? old('ad_onsite_price') : $data->ad_onsite_price }}" step="0.1"
                name="ad_onsite_price" type="text" class="form-control required" id="ad_onsite_price" placeholder="Onsite price excluding vat" related-input="ad_onsite_price_with_vat">
        </div>

        <div class="form-group col-md-6">
            <label for="ad_with_vat">Online price with vat</label>
            <input value="{{ old('ad_with_vat') ? old('ad_with_vat') : $data->ad_with_vat }}" name="ad_with_vat"  step="0.1"
                type="text" class="form-control required" id="ad_with_vat" placeholder="Online price with vat" readonly>
        </div>

        <div class="form-group col-md-6">
            <label for="ad_onsite_price_with_vat">Onsite price with vat</label>
            <input
                value="{{ old('ad_onsite_price_with_vat') ? old('ad_onsite_price_with_vat') : $data->ad_onsite_price_with_vat }}"
                name="ad_onsite_price_with_vat" type="text" class="form-control required" id="ad_onsite_price_with_vat"  step="0.1"
                placeholder="Onsite price with vat" readonly>
        </div>
        <div class="col-md-6"></div>
        <div class="form-group col-md-6">
            <label class="mb-2" for="inputAddress2">Social Media</label>
            <div class="row pl-1">
                @foreach ($socialMedia as $item)
                    @php $influencerSocial =  $data->socialMediaProfiles()->where('social_media_id',$item->id)->first() ?? false; @endphp
                    <div class="input-group mb-1 col-8 form-group">
                        <label for="Username{{$item->id}}" class="col-12 p-0">{{ $item->name }} Username</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                @switch($item->name)
                                    @case('Facebook')
                                        <i class="fab fa-facebook-square"></i>
                                        @break
                                    @case('Snapchat')
                                        <i class="fab fa-snapchat-square"></i>
                                        @break
                                    @case('Twitter')
                                        <i class="fab fa-twitter-square"></i>
                                        @break
                                    @case('Instagram')
                                        <i class="fab fa-instagram-square"></i>
                                        @break
                                    @case('Youtube')
                                        <i class="fab fa-youtube"></i>
                                        @break
                                    @case('Tiktok')
                                        <i class="fab fa-tiktok"></i>
                                        @break
                                    @default
                                        
                                @endswitch
                               
                            </span>
                        </div>
                        <input type="text" id="Username{{$item->id}}" name="social_media[{{$item->id}}][link]" class="{{$item->id == 4 ? 'required' : ''}} form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" value="{{ $influencerSocial ? $influencerSocial->link : ''}}">
                    </div>
                    <div class="col-4 mb-1 form-group">
                        <label for="subscribers{{$item->id}}">Subscribers</label>
                        <input type="number" min="0" name="social_media[{{$item->id}}][subscribers]"  id="subscribers{{$item->id}}" class="form-control {{$item->id == 4 ? 'required' : ''}}" placeholder="Subscribers" aria-label="Subscribers" aria-describedby="basic-addon1" value="{{ $influencerSocial ? $influencerSocial->views : 0}}">
                        <input type="hidden" name="social_media[{{$item->id}}][type]" value="{{$item->id}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>