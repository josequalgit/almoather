<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">Website Description</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
     
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.frontEndSettings.updateWebsiteDescription') }}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                   
                      <textarea name="description_ar" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_ar')?old('description_ar'):$appSettingInfo->ar }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_en')?old('description_en'):$appSettingInfo->en }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                  
              </div>
           

          </div>
    </div>
</div>