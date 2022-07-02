@if($matchedInfluencers->count())
    @include('dashboard.ads.include.influencers')
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