<h3 class="f-16 ad-title">CAMPAIGN</h3>
<section>
    <div class="camp-section">
        <div class="add-section">
            <h3 class="f-16 ad-title" style="">Campaign Details({{ $data->store }})</h3>
            <div class="blocks-list">
                <div class="w-100  justify-content-center">
                    <div class="details-banner ad-details">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 text-center w-100">
                                <img class="ad-image" src="{{ $data->logo['url'] }}" alt="{{ $data->store }}">
                                <h3 class="title mt-2">{{ $data->customers->full_name }}</h3>
                            </div>
                            <div class="col details-content">
                                <div class="pb-1">
                                    <b class="me-2">Trade Mark Name:</b> <span
                                        class="me-2">{{ $data->store }}</span>
                                </div>
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">Cr Number : </b><span
                                        class="me-2">{{ $data->cr_num }}</span>
                                </div>
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">Cr Document : </b><span
                                        class="me-2"><a href="{{ $data->crImage->url ?? '' }}" target="_blank">Download</a></span>
                                </div>
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">Budget: </b><span
                                        class="me-2">{{ number_format($data->budget) }}</span>
                                </div>
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="mr-2">Category:</b>
                                    @if ($data->categories)
                                        <span class="tag me-2 category-item">{{ $data->categories->name }}</span>
                                    @else
                                        <span class="tag me-2 category-item">No Category Choosen</span>
                                    @endif
                                </div>
                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Description:</b> <span
                                        class="me-2">{{ $data->about }}</span>
                                </div>
                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Is Store Verified Through Marouf:</b> <span
                                        class="me-2">{{ $data->marouf_num ? 'Yes' : 'No' }}</span>
                                </div>
                                @if ($data->marouf_num)
                                    <div class="border-top pt-1 pb-1">
                                        <b class="me-2">Marouf Number:</b> <span
                                            class="me-2">{{ $data->marouf_num }}</span>
                                    </div>
                                @endif
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">is vat: </b><span
                                        class="me-2">{{ $data->is_vat ? 'Yes' : 'No' }}</span>
                                </div>

                                @if ($data->is_vat)
                                    <div class="hashs border-top pt-1 pb-1">
                                        <b class="me-2">Tax Number: </b><span
                                            class="me-2">{{ $data->tax_value }}</span>
                                    </div>
                                @endif
                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">Relationship With Brand: </b><span
                                        class="me-2">{{ $data->relations ? $data->relations->title : $data->relation }}</span>
                                </div>

                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">About The Company (Brand): </b><span
                                        class="me-2">{{ $data->about }}</span>
                                </div>

                                <div class="hashs border-top pt-1 pb-1">
                                    <b class="me-2">About The Product: </b><span
                                        class="me-2">{{ $data->about_product }}</span>
                                </div>

                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Campaign Goals:</b> <span
                                        class="me-2">{{ $data->campaignGoals?$data->campaignGoals->title:null }}</span>
                                </div>

                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Type:</b> <span
                                        class="me-2">{{ trans('messages.frontEnd.'.$data->ad_type) }}</span>
                                </div>

                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">On: </b> <span class="me-2">
                                        @foreach ($data->socialMedias as $item)
                                            <img src="{{ $item->image }}" class="rounded-circle social-media-icon" />
                                        @endforeach
                                    </span>
                                </div>
                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Link: <a target="_blank"
                                            href="{{ $data->store_link }}">{{ $data->store_link }}</a> </b>
                                </div>
                                <div class="border-top pt-1 pb-1 mb-3">
                                    <b class="me-2">Status: {{ $data->status }} </b><span
                                        class="me-2"></span>
                                </div>

                                <h4>Location</h4>
                                <div class="border-top pt-1 pb-1">
                                    <b class="me-2">Country:</b> <span
                                        class="me-2">{{ $data->countries?$data->countries->name:null }}</span>
                                </div>
                                <div class="pt-1 pb-1">
                                    <b class="me-2">City:</b> <span
                                        class="me-2">{{ $data->cities?$data->cities->name:null }}</span>
                                </div>
                                <div class="pt-1 pb-1">
                                    <b class="me-2">Area:</b> <span
                                        class="me-2">{{ $data->areas?$data->areas->name:null }}</span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="container">
                                <h4>Commercial Documents</h4>
                                <div class="row border-top pt-1 pb-1">
                                    @if($data->document)
                                    @foreach ($data->document as $key => $document)
                                    <a class="col-lg-3 col-md-4 col-6 pt-2 pb-2 pl-1 video-item d-flex align-items-center mb-2" href="{{ $document->url }}" target="_blank">
                                        <div>
                                            <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                        </div>
                                        <div class="ml-2">
                                            <h6 class="mb-0">Document #{{$key + 1}}</h6>
                                        </div>
                                    </a>
                                    @endforeach
                                    @else
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            No documents found
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-center"></div>
</section>
