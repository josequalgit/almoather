<h3 class="f-16 ad-title">LIVE</h3>
<section>
    <div class="add-section">
        <div class="blocks-table d-block">
            <table class="table zero-configuration table-influencers col-12 mb-3">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nickname</th>
                        <th>Price</th>
                        @if($data->campaignGoals->profitable)
                        <th>ROAS</th>
                        @else
                        <th>Engagment Rate</th>
                        <th>AOAF</th>
                        @endif
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @php $totalPrice = 0; @endphp
                    @foreach ($matchedInfluencers as $item)
                        @php 
                        $price = $data->ad_type == 'online' ? $item->influencers->ad_price : $item->influencers->ad_onsite_price;
                        $totalPrice += $price;
                        @endphp
                        <tr>
                            <td>
                                <div class="thumb">
                                    <img class="img-fluid inf-image" src="{{ $item->influencers->users ? $item->influencers->users->infulncerImage['url'] : null }}" alt="">
                                </div>
                            </td>
                            <td>{{ $item->influencers->nick_name }}</td>
                            <td>{{ $price }}</td>
                            @if($data->campaignGoals->profitable)
                                <td>{{ $item->match ?? 0 }}%</td>
                            @else
                                <td>{{ $item->match ?? 0 }}%</td>
                                <td>{{ $item->AOAF ?? 0 }}%</td>
                            @endif
                            <td>{{ $item->influencers->isBigInfluencer ? 'Big Influencer' : 'Small Influencer' }}</td>
                            <td>{{ ucwords(str_replace('_',' ',$item->status)) }}</td>
                            <td>
                                <button type="button" onclick="getUnchosenInfulncers(this,'{{ $item->influencers->id }}')" class="btn btn-secondary">
                                    <i class="bx bx-transfer"></i>
                                </button>
                                <button type="button" onclick="removeInfluencer(this,'{{ $item->influencers->id }}')" class="btn btn-danger">
                                    <i class="fas fa-user-times"></i>
                                </button>
                               
                            </td>
                        </tr>
                    @endforeach
                   
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-6 col-md-12 p-2">
                    <div class="count-box list">
                        <span> <i class="bx bx-user"></i>Total Influencers:</span><span class="numbers"><b>{{ number_format($matchedInfluencers->count()) }}</b></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 p-2">
                    <div class="count-box list">
                        <span> <i class="bx bx-money"></i>Total Budget:</span><span class="numbers"><b>{{ number_format($data->budget - (0.15 * $data->budget)) }}</b></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 p-2">
                    <div class="count-box list">
                        <span> <i class="bx bx-money"></i>Influncers Toal Price:</span><span class="numbers"><b>{{ number_format($totalPrice) }}</b></span>
                    </div>
                </div>
            
                <div class="col-lg-6 col-md-12 p-2">
                    <div class="count-box list">
                        <span> <i class="bx bx-money"></i>Remaining Budget:</span><span class="numbers"><b>{{ number_format($data->budget - (0.15 * $data->budget) - $totalPrice) }}</b></span>
                    </div>
                </div>
            </div>
            @if ($data->status == 'choosing_influencer' && $data->admin_approved_influencers == 0)
                <div class="d-flex justify-content-center">
                    <button  type="button" onclick="approveInfluencersList(this)" class="btn btn-primary w-25">Approve Influencers List</button>
                </div>  
            @endif
        </div>
    </div>
</section>