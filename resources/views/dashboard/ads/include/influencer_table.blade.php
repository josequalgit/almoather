@if($allInfluencer->count())

<table class="table zero-configuration table-influencers col-12 mb-3">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nickname</th>
            @if($ad->campaignGoals->profitable)
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
        @foreach ($allInfluencer as $item)
            @php 
            $price = $ad->ad_type == 'online' ? $item->influencers->ad_price : $item->influencers->ad_onsite_price;
            $totalPrice += $price;
            @endphp
            <tr>
                <td>
                    <div class="thumb">
                        <img class="img-fluid inf-image" src="{{ $item->influencers->users ? $item->influencers->users->infulncerImage['url'] : null }}" alt="">
                    </div>
                </td>
                <td>{{ $item->influencers->nick_name }}</td>
                <td>{{ $ad->ad_type == 'online' ? $item->influencers->ad_price : $item->influencers->ad_onsite_price }}</td>
                @if($ad->campaignGoals->profitable)
                    <td>{{ $item->match }}%</td>
                @else
                    <td>{{ $item->match }}%</td>
                    <td>{{ $item->AOAF }}%</td>
                @endif
                <td>{{ $item->influencers->isBigInfluencer ? 'Big Influencer' : 'Small Influencer' }}</td>
                <td>{{ ucwords(str_replace('_',' ',$item->status)) }}</td>
                <td>
                    <button type="button" onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')" class="btn btn-secondary">
                        <i class="bx bx-transfer"></i>
                    </button>
                   
                </td>
            </tr>
        @endforeach
       
    </tbody>
</table>
<div class="row">
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-user"></i>Total Influencers:</span><span class="numbers"><b>{{ number_format($allInfluencer->count()) }}</b></span>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Total Budget:</span><span class="numbers"><b>{{ number_format($ad->budget) }}</b></span>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Influncers Toal Price:</span><span class="numbers"><b>{{ number_format($totalPrice) }}</b></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Remaining Budget:</span><span class="numbers"><b>{{ number_format($ad->budget - $totalPrice) }}</b></span>
        </div>
    </div>
</div>
@else
<div class="px-2">
    <div class="alert alert-info text-ceter mt-3">
        <h6 class="mb-0">No Influencers were found that matched this campaign. Possible Reasons:</h6>
        <ol type="1">
            @foreach($noInfluencerReasons as $reason)
            <li>{{$reason}}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif