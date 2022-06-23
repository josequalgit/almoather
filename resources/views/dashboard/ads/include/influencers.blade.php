<h3 class="f-16 ad-title">LIVE</h3>
@php 
$totalPrice = 0;
$notShowSinarioStatuses = ['prepay','pending','cancelled','approved',];  
@endphp
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
                        @if(!in_array($data->status,$notShowSinarioStatuses))
                        <th>Date</th>
                        <th>Sinario</th>
                        @endif
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                   
                    @foreach ($matchedInfluencers as $item)
                        @php 
                        $price = $data->ad_type == 'online' ? $item->influencers->ad_price : $item->influencers->ad_onsite_price;
                        $totalPrice += $price;
                        $contract = $item->contract;
                        @endphp
                        <tr data-id="{{ $item->influencers->id }}">
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
                            @if(!in_array($data->status,$notShowSinarioStatuses))
                                <td class="date {{ $contract ? 'has-content' : ''}}">{{ $contract ? $contract->date : 'Not set' }}</td>
                                <td class="sinario {{ $contract ? 'has-content' : ''}}">{{ $contract ? $contract->scenario : 'Not set' }}</td>
                            @endif
                            <td>{{ $item->influencers->isBigInfluencer ? 'Big Influencer' : 'Small Influencer' }}</td>
                            <td>{{ ucwords(str_replace('_',' ',$item->status)) }}</td>
                            <td>
                                <button type="button" onclick="getUnchosenInfulncers(this,'{{ $item->influencers->id }}')" class="btn btn-secondary btn-sm mb-1">
                                    <i class="bx bx-transfer"></i>
                                </button>
                                <button type="button" onclick="removeInfluencer(this,'{{ $item->influencers->id }}')" class="btn btn-danger btn-sm mb-1">
                                    <i class="fas fa-user-times"></i>
                                </button>
                                @if ($data->status == 'choosing_influencer' && $data->admin_approved_influencers == 0)
                                    <button  type="button" onclick="seeContract(this,'{{ $item->influencers->id }}')" class="btn btn-secondary btn-sm"><i class="fas fa-file-signature"></i></button>
                                @endif
                               
                            </td>
                        </tr>
                    @endforeach
                   
                </tbody>
            </table>
            @if ($data->status == 'choosing_influencer' && $data->admin_approved_influencers == 0)
                <div class="d-flex justify-content-center">
                    <button  type="button" onclick="approveInfluencersList(this)" class="btn btn-secondary">Approve Influencers List</button>
                </div> 
            @endif
            <div class="row mt-2">
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
            
        </div>
    </div>
</section>