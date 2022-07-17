<h3 class="f-16 ad-title">CONTENT</h3>
<section>
    <div class="add-section contentSection">
        <div class="box-border">
            <div class="top-section">
                <div class="selected-items row"></div>
            </div>
            <div class="main-section d-flex justify-content-center p-2">
                <div class="card col">
                    <form>
                        <div class="col p-4">
                            <div>
                                <h6 for="add_category">Add Influncers Requarment</h6>
                                <div class="row p-4 add_space">
                                    <div class="col">
                                        <label for="">Type</label>
                                        <select class="form-control" id="ad-type" name="ad_type" >
                                            <option {{ $data->type == 'product' ? 'selected' : '' }} value="product" data-items="{{json_encode($productCategories)}}" >منتج</option>
                                            <option {{ $data->type == 'service' ? 'selected' : '' }} value="service" data-items="{{json_encode($serviceCategories)}}">خدمة</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="">Category</label>
                                        <select class="form-control" id="ad-category" data-item="{{$data->category_id}}"></select>
                                    </div>
                                    
                                    @if (!$data->campaignGoals->profitable)
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Engagement rate</label>
                                                <input id="eng_number" class="form-control" type="number" value="0" min='0' max='100' value="{{$data->eng_number}}" />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row p-4  align-items-center">
                                <h6 for="add_category">Videos</h6>
                                <button type="button" class="btn btn-info ml-2 open-choose-video">Add</button>
                                <input type="file" id="adVideo" style="display:none" />
                            </div>
                            <div id="videoSection" class="row video-section p-1">
                                @foreach ($data->videos as $key => $item)
                                    <div class="col-md-4 col-6 mt-2" data-id="{{ $item->id }}">
                                        <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                            <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $item->thumbnail }}" width="40" />
                                            </a>
                                            <div class="ml-2">
                                                <h6 class="mb-0">Video #{{ $key + 1 }}</h6>
                                                <div class="about"><button onclick="deleteFileModal({{ $item->id }})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col">
                            <div class="row p-4  align-items-center">
                                <h6 for="add_category">Images</h6>
                                <button type="button" class="btn btn-info ml-2 open-choose-image">Add</button>
                                <input type="file" id="addImage" style="display:none" />
                            </div>
                            <div id="imageSection" class="row video-section p-1 mb-2">
                                @foreach ($data->image as $key => $item)
                                    <div class="col-md-4 col-6 mt-2" data-id="{{ $item->id }}">
                                        <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                            <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $item->url }}" width="40" />
                                            </a>
                                            <div class="ml-2">
                                                <h6 class="mb-0">Image #{{ $key + 1 }}</h6>
                                                <div class="about"><button onclick="deleteFileModal({{ $item->id }})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>