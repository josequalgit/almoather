<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">Location</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
     
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.frontEndSettings.updateMapLink') }}">
                    @csrf
                  
                    <div class="form-group text-center">
                      <label class="mb-2" for="title_ar">Link</label>
                      
                      <input value="{{ old('link')?old('link'):$appSettingInfo->link }}" type="text" class="form-control" name="link"  aria-describedby="emailHelp" placeholder="link">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                  
              </div>
           

          </div>
    </div>
</div>