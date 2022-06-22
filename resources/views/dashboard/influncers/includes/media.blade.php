<h3>Media Information</h3>
<section id='basic-input'>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="nick_name">Nick Name</label>
            <input value="{{ old('nick_name') ? old('nick_name') : $data->nick_name }}" name="nick_name" type="text"
                class="form-control" id="nick_name" placeholder="nick_name">
        </div>
        <div class="form-group col-md-6">
            <label for="bio">About Me</label>
            <textarea id="bio" class="form-control">{{ old('bio') ? old('bio') : $data->bio }}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="ads_out_country">Accept advertisment outside region</label>
            <select name="ads_out_country" id="ads_out_country" class="form-control">
                <option value="1" {{ $data->ads_out_country ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $data->ads_out_country ? '' : 'selected' }}>No</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="ad_price">Online price excluding vat</label>
            <input value="{{ old('ad_price') ? old('ad_price') : $data->ad_price }}" name="ad_price" type="number" step="0.1"
                class="form-control" id="ad_price" placeholder="ad_price">
        </div>

        <div class="form-group col-md-6">
            <label for="ad_onsite_price">Onsite price excluding vat</label>
            <input value="{{ old('ad_onsite_price') ? old('ad_onsite_price') : $data->ad_onsite_price }}" step="0.1"
                name="ad_onsite_price" type="text" class="form-control" id="ad_onsite_price" placeholder="ad_onsite_price">
        </div>

        <div class="form-group col-md-6">
            <label for="ad_with_vat">Online price with vat</label>
            <input value="{{ old('ad_with_vat') ? old('ad_with_vat') : $data->ad_with_vat }}" name="ad_with_vat"  step="0.1"
                type="text" class="form-control" id="ad_with_vat" placeholder="ad_with_vat">
        </div>

        <div class="form-group col-md-6">
            <label for="ad_onsite_price_with_vat">Onsite price with vat</label>
            <input
                value="{{ old('ad_onsite_price_with_vat') ? old('ad_onsite_price_with_vat') : $data->ad_onsite_price_with_vat }}"
                name="ad_onsite_price_with_vat" type="text" class="form-control" id="ad_onsite_price_with_vat"  step="0.1"
                placeholder="ad_onsite_price_with_vat">
        </div>

        <div class="form-group col-md-6">
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
    </div>
</section>