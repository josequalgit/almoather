<h3>Category and status</h3>
<section id="basic-input">
    @if ($data->rejected_note)
        <div class="form-group">
            <label for="inputAddress2">Rejected Note</label>
            <textarea class="form-control" rows="12" disabled>{{ old('rejected_note') ? old('rejected_note') : $data->rejected_note }}</textarea>
        </div>
    @endif

    <div class="form-group">
        <label for="inputAddress2">Categories</label>

        <div class="input-group mt-2">
            <div class="row">
                @foreach ($categories as $item)
                    <div class="col-lg-3 col-6 form-group">
                        <input class="check_class" name="categories[]"
                            {{ in_array($item->id, $infCategories) ? 'checked' : '' }} class="form-check-input"
                            type="checkbox" id="inlineCheckbox{{ $item->id }}" value="{{ $item->id }}">
                        <label class="form-check-label pl-1" for="inlineCheckbox{{ $item->id }}">
                            {{ $item->name }} </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress2">Status</label>
        <select id="status" class="form-control" id="exampleFormControlSelect1">
            <option {{ $data->status == 'pending' ? 'selected' : '' }} disabled value="pending">Pending</option>
            <option {{ $data->status == 'accepted' ? 'selected' : '' }} value="accepted">Accepted</option>
            <option {{ $data->status == 'rejected' ? 'selected' : '' }} value="rejected">Rejected</option>
            <option {{ $data->status == 'band' ? 'selected' : '' }} value="band">Band</option>
        </select>
    </div>
    <div class="form-group text-right">
        @can('Edit Influncer')
            <button onclick="changeStatus()" type="button" class="mt-2 btn btn-primary float-right">Change</button>
        @endcan
    </div>
</section>