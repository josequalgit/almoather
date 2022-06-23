<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">Login Text</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
     
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.frontEndSettings.updateLoginText') }}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Title Ar</label>
                   
                      <input name="title_ar" class="form-control" id="exampleFormControlTextarea1" value="{{ old('title_ar')?old('title_ar'):$appSettingInfo->title->ar }}" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Title En</label>
                      <input name="title_en" class="form-control" id="exampleFormControlTextarea1" value="{{ old('title_en')?old('title_en'):$appSettingInfo->title->en }}">
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