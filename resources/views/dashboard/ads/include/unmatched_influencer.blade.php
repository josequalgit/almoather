<table class="table manage-candidates-top mb-0">

    <tbody>
        
        @foreach ($unMatched as $item)
            <tr class="candidates-list bg-dnager">
                <td class="title">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null }}" alt="">
                    </div>
                    <div class="candidate-list-details">
                        <div class="candidate-list-info">
                            <div class="candidate-list-title">
                                <h5 class="mb-0">
                                    {{ $item->influencers->first_name }}
                                    {{ $item->influencers->middle_name }}
                                    {{ $item->influencers->last_name }}</h5>
                                <span
                                    style="font-size:12px;">{{ $item->match }}%</span><br />
                            </div>
                        </div>

                    </div>
                    <div class="col">
                        <button style="background:none; border:none;"
                            onclick="replaceInfluncer('{{ $item->influencers->id }}',)"
                            class="float-right" href="http://" target="_blank"
                            rel="noopener noreferrer">
                            <h5>chose</i></h5>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>