<h3>Category and status</h3>
<section id="basic-input">
    

    <div class="form-group">
        <label for="inputAddress2">Categories</label>
        <select name="categories[]" id="categories" class="form-control select2-init required" multiple>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}" {{ in_array($item->id, $infCategories) ? 'selected' : '' }} >{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" class="form-control required" name="status" >
            <option {{ $data->status == 'pending' ? 'selected' : '' }} disabled value="pending">Pending</option>
            <option {{ $data->status == 'accepted' ? 'selected' : '' }} value="accepted">Accepted</option>
            <option {{ $data->status == 'rejected' ? 'selected' : '' }} value="rejected">Rejected</option>
            <option {{ $data->status == 'band' ? 'selected' : '' }} value="band">Band</option>
        </select>
    </div>

    <div class="form-group reject-wrapper" style="{{ $data->status != 'rejected' ? "display:none" : ""}}">
        <label for="rejectedNote">Status</label>
        <textarea class="form-control" id="rejectedNote" rows="12" name="rejected_note">{{ $data->rejected_note }}</textarea>
    </div>

</section>