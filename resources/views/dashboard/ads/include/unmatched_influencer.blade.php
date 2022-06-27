<div class="table-responsive">
<table class="table zero-configuration table-influencers">
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
            <th>Over Budget</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="table-body">
        @foreach ($unMatched as $item)
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
                <td>{{ $item->influencers->TypeInfluencerSubscriber }}</td>
                <td>{{ ucwords(str_replace('_',' ',$item->status)) }}</td>
                <td>{{ $price <= $influencerPrice ? 'No' : 'Yes'  }}</td>
                <td>
                    @if ($price <= $influencerPrice)
                    <button class="btn btn-secondary" onclick="replaceInfluncer(this,'{{ $item->influencers->id }}')"> <i class="bx bx-check"></i></button>
                    @else
                    <button class="btn btn-secondary" disabled><i class="bx bx-check"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
       
    </tbody>
</table>
</div>