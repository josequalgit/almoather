
<table class="table zero-configuration table-influencers col-12">
    <thead>
        <tr>
            <th>Image</th>
            <th>Full name</th>
            <th>Match</th>
            <th>Chosen</th>
            <th>Status</th>
            <th>Accepted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="table-body">
        @if($allInfluencer)
        @foreach ($allInfluencer as $item)
            <tr>
                <td>
                    <div class="thumb">
                        <img class="img-fluid inf-image" src="{{ $item->users->infulncerImage ? $item->users->infulncerImage['url'] : null }}" alt="">
                    </div>
                </td>
                <td>{{ $item->full_name }}</td>
                <td>{{ $item->match }}%</td>
                <td>{{ $item->chosen ? 'Yes' : 'No' }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    @if ($item->influencers->checkIfAccepted($data->id) == 1)
                        Yes
                    @elseif($item->influencers->checkIfAccepted($data->id) == 2)
                        No Contract avalibale
                    @else
                        No
                    @endif
                </td>
                <td>
                    @if ($data->status == 'approve' || $data->status == 'fullpayment')
                        <button {{ $item->influencers->checkIfAccepted($data->id) == 1 ? 'disabled' : '' }} type="button" onclick="seeContract('{{ $data->contacts->content }}','{{ $item->influencers->id }}')" class="btn btn-secondary">
                            <i class="bx bx-send "></i>
                        </button>
                    @endif

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