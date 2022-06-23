<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">Register Type</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
     
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" action="{{ route('dashboard.frontEndSettings.registerType') }}">
                    @csrf
                  
                    <div class="form-group">
                      <label for="title_ar">Title Ar</label>
                      <input type="text" value="{{ old('title_ar')?old('title_ar'):$appSettingInfo->title->ar }}" class="form-control" name="title_ar" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_en">Title En</label>
                      <input value="{{ old('title_en')?old('title_en'):$appSettingInfo->title->en }}" type="text" class="form-control" name="title_en" id="title_en" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                      <textarea name="description_ar" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_ar')?old('description_ar'):$appSettingInfo->description->ar }}</textarea>

                   
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_en')?old('description_en'):$appSettingInfo->description->en }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                  
              </div>
           

          </div>
    </div>
</div>