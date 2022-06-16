
<table class="table zero-configuration table-influencers col-12">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nickname</th>
            <th>Match</th>
            <th>Chosen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="table-body">
        @if($allInfluencer)
        @foreach ($allInfluencer as $item)
            <tr>
                <td>
                    <div class="thumb">
                        <img class="img-fluid inf-image" src="{{ $item->influencers->users ? $item->influencers->users->infulncerImage['url'] : null }}" alt="">
                    </div>
                </td>
                <td>{{ $item->influencers->nick_name }}</td>
                <td>{{ $item->match }}%</td>
                <td>{{ $item->chosen ? 'Yes' : 'No' }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    <button type="button" onclick="getUnchosenInfulncers('{{ $item->influencers->id }}')" class="btn btn-secondary">
                        <i class="bx bx-transfer"></i>
                    </button>
                   
                </td>
            </tr>
        @endforeach
        @else
        <tr><td colspan="7" class="text-ceter">No Influencers found that matched this campaign</td></tr>
        @endif
    </tbody>
</table>