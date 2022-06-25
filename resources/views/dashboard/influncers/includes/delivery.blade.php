<h3>Delivery Address Information</h3>
<section id="basic-input">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="rep_full_name">Full Name of shopment riceiver</label>
            <input value="{{ old('rep_full_name') ? old('rep_full_name') : $data->rep_full_name }}" name="rep_full_name"
                type="text" class="form-control required" id="rep_full_name" placeholder="Full Name of shopment riceiver">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Phone Number of shopment riceiver</label>
            <input value="{{ old('rep_phone_number') ? old('rep_phone_number') : $data->rep_phone_number }}"
                name="rep_phone_number" type="text" class="form-control required" id="rep_phone_number"
                placeholder="Phone Number of shopment riceiver">
        </div>
        <div class="form-group col-md-6">
            <label for="rep_city">City</label>
            <select name="rep_city" id="rep_city" class="form-control required" data-value="{{ $data->rep_city }}"></select>
        </div>
        <div class="form-group col-md-6">
            <label for="rep_area">Area</label>
            <input value="{{ old('rep_area') ? old('rep_area') : $data->rep_area }}" name="rep_area" type="text"
                class="form-control required" id="rep_area" placeholder="Area">
        </div>
        <div class="form-group col-md-6">
            <label for="street">Street</label>
            <input value="{{ $data->street }}" name="street"
                type="text" class="form-control" id="street" placeholder="Street">
        </div>
        <div class="form-group col-md-6">
            <label for="milestone">Milestone</label>
            <input value="{{ old('milestone') ? old('milestone') : $data->milestone }}" name="milestone" type="text"
                class="form-control" id="milestone" placeholder="Milestone">
        </div>

        <div class="form-group col-md-6">
            <label for="neighborhood">Neighborhood</label>
            <input value="{{ old('neighborhood') ? old('neighborhood') : $data->neighborhood }}" name="neighborhood" type="text"
                class="form-control" id="neighborhood" placeholder="Milestone">
        </div>
    </div>

</section>