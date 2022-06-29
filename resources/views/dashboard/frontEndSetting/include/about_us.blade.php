<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">About Us(brief)</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
     
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.frontEndSettings.updateBriefAboutUs') }}">
                    @csrf
                  
                    <div class="form-group text-center">
                      <img class="avatar mb-2 rounded fit-image" width="150px" height="150px" src="{{ $data?$data->image:null }}" alt="">
                      <input type="file" class="form-control" name="image" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>

                    <div class="form-group">
                      <label for="title_ar">Title Ar</label>
                      <input type="text" value="{{ old('title_ar')?old('title_ar'):$data->getTranslation('title','ar') }}" class="form-control" name="title_ar" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_en">Title En</label>
                      <input value="{{ old('title_en')?old('title_en'):$data->getTranslation('title','en') }}" type="text" class="form-control" name="title_en" id="title_en" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                      <textarea name="description_ar" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_ar')?old('description_ar'):$data->getTranslation('description','ar') }}</textarea>

                   
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_en')?old('description_en'):$data->getTranslation('description','en') }}</textarea>
                    </div>

                    <div class="mt-3 mb-2">
                      <h4>Page</h4>
                      <hr/>
                    </div>
                    <div class="text-left">
                      <h4><span class="badge">Header Image</span></h4>
                    </div>
                    <div class="form-group text-center">
                      <img class="avatar mb-2 rounded fit-image" width="150px" height="150px" src="{{ $data?$data->aboutUsHeader:null }}" alt="">
                      <input type="file" class="form-control" name="header_image" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    
                    <div class="text-left">
                      <h4><span class="badge mb-1 mt-1">First Section</span></h4>
                    </div>
                    <div class="form-group text-center">
                      <img class="avatar mb-2 rounded fit-image" width="150px" height="150px" src="{{ $data?$data->aboutUsSectionOneImage:null }}" alt="">
                      <input type="file" class="form-control" name="section_one_image" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_ar_section_one">Title Ar</label>
                      <input type="text"  value="{{ old('title_en_section_one')?old('title_en_section_one'):$data->contentData?->section_one->title_ar }}" class="form-control" name="title_ar_section_one" id="title_ar_section_one" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_en_section_one">Title En</label>
                      <input value="{{ old('title_en_section_one')?old('title_en_section_one'):$data->contentData?->section_one->title_en }}" type="text" class="form-control" name="title_en_section_one" id="title_en_section_one" placeholder="title">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                      <textarea name="description_ar_section_one" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_ar_section_one')?old('description_ar_section_one'):$data->contentData?->section_one->description_ar }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en_section_one" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_en_section_one')?old('description_en_section_one'):$data->contentData?->section_one->description_en }}</textarea>
                    </div>


                    <div class="text-left">
                      <h4><span class="badge mb-1 mt-1">Second Section</span></h4>
                    </div>
                    <div class="form-group text-center">
                      <img class="avatar mb-2 rounded fit-image" width="150px" height="150px" src="{{ $data?$data->aboutUsSectionTwoImage:null }}" alt="">
                      <input type="file" class="form-control" name="section_two_image" id="title_ar" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_ar_section_two">Title Ar</label>
                      <input type="text"  value="{{ old('title_en_section_two')?old('title_en_section_two'):$data->contentData?->section_two->title_ar }}" class="form-control" name="title_ar_section_two" id="title_ar_section_two" aria-describedby="emailHelp" placeholder="title">
                    </div>
                    <div class="form-group">
                      <label for="title_en_section_two">Title En</label>
                      <input value="{{ old('title_en_section_two')?old('title_en_section_two'):$data->contentData?->section_two->title_en }}" type="text" class="form-control" name="title_en_section_two" id="title_en_section_two" placeholder="title">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                      <textarea name="description_ar_section_two" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_ar_section_two')?old('description_ar_section_two'):$data->contentData?->section_two->description_ar }}</textarea>

                   
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en_section_two" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('description_en_section_two')?old('description_en_section_two'):$data->contentData?->section_one->description_en }}</textarea>
                    </div>

                    


                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                  
              </div>
           

          </div>
    </div>
</div>