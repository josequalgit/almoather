@if($matchedInfluencers->count())
<div class="table-responsive mb-2">
 
    <table class="table zero-configuration table-influencers col-12">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nickname</th>
                <th>Price</th>
                @if($ad->campaignGoals->profitable)
                <th>ROAS</th>
                @else
                <th>Engagment Rate</th>
                <th>AOAF</th>
                @endif
                <th>Influencer Type</th>
                <th>Choose Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="table-body">
           
            @foreach ($matchedInfluencers as $item)
                @php 
                $price = $ad->ad_type == 'online' ? $item->influencers->ad_with_vat : $item->influencers->ad_onsite_price_with_vat;
                @endphp
                <tr>
                    <td>
                        <div class="thumb">
                            <img class="img-fluid inf-image" src="{{ $item->influencers->users ? $item->influencers->users->infulncerImage['url'] : null }}" alt="">
                        </div>
                    </td>
                    <td>{{ $item->influencers->nick_name }}</td>
                    <td>{{ $price }}</td>
                    @if($ad->campaignGoals->profitable)
                        <td>{{ $item->match ?? 0 }}%</td>
                    @else
                        <td>{{ $item->match ?? 0 }}%</td>
                        <td>{{ $item->AOAF ?? 0 }}</td>
                    @endif
                    <td>{{ $item->influencers->TypeInfluencerSubscriber  }}</td>
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
</div>
<div class="row">
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-user"></i>Total Influencers:</span><span class="numbers"><b>{{ number_format($matchedInfluencers->count()) }}</b></span>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Budget:</span><span class="numbers"><b>{{ number_format($ad->budget) }}</b></span>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Toal Price:</span><span class="numbers"><b>{{ number_format($ad->price_to_pay) }}</b></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-12 p-2">
        <div class="count-box list">
            <span> <i class="bx bx-money"></i>Remaining Budget:</span><span class="numbers"><b>{{ number_format($ad->budget - $ad->price_to_pay) }}</b></span>
        </div>
    </div>
</div>
@else
<div class="px-2">
    <div class="alert alert-danger text-ceter mt-3">
        <p class="">No Influencers were found that matched this campaign. Possible Reasons:</p>
        <ol type="1">
            @foreach($noInfluencerReasons as $reason)
            <li>{{$reason}}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif