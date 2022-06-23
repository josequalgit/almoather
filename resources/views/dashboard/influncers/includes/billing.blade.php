<h3>Bank Information</h3>
<section id="basic-input">
    <div class="form-group">
        <label for="bank_account_name">Bank Account Name</label>
        <input value="{{ old('bank_account_name') ? old('bank_account_name') : $data->bank_account_name }}"
            name="bank_account_name" type="text" class="form-control" id="bank_account_name"
            placeholder="Bank Account Name">
    </div>
    <div class="form-group">
        <label for="bank_name">Bank Name</label>
        <input value="{{ old('bank_name') ? old('bank_name') : $data->banks->name }}" name="bank_name"
            type="text" class="form-control" id="bank_name" placeholder="Bank Name">
    </div>
    <div class="form-group">
        <label for="bank_account_number">Bank Account Number</label>
        <input value="{{ old('bank_account_number') ? old('bank_account_number') : $data->bank_account_number }}"
            name="bank_account_number" type="text" class="form-control" id="bank_account_number"
            placeholder="Bank Account Number">
    </div>
    <div class="form-group">
        <label for="commercial_registration_no">Commercial Registration No</label>
        <input
            value="{{ old('commercial_registration_no') ? old('commercial_registration_no') : $data->commercial_registration_no }}"
            name="commercial_registration_no" type="text" class="form-control" id="commercial_registration_no"
            placeholder="Commercial Registration No">
    </div>
    @if ($data->commercialFiles)
        <div class="form-group">
            <label for="commercialFiles">Commercial Registration Files</label>
            <br />
            <a target="_blink" class="btn btn-secondary" href="{{ $data->commercialFiles['url'] }}" download>
                Download
            </a>
        </div>
    @endif
    <div class="form-group">
        <label for="tax_registration_number">Tax Registration Number</label>
        <input
            value="{{ old('tax_registration_number') ? old('tax_registration_number') : $data->tax_registration_number }}"
            name="tax_registration_number" type="text" class="form-control" id="tax_registration_number"
            placeholder="tax_registration_number">
    </div>
    @if ($data->taxFiles)
        <div class="form-group">
            <label for="tax">Tax Files</label>
            <br />
            <a target="_blink" class="btn btn-secondary" href="{{ $data->taxFiles['url'] }}" download>
                Download
            </a>
        </div>
    @endif

</section>