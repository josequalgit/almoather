<div class="card">
    <div class="card-header pb-0">
        <div class="card-title">
            <p class="mb-0">Our Service</p>
        </div>
        <hr class="w-100 my-1">
    <div class="row w-100">                             
          <div class="col">
              <div id="WelcomeMessage" class="tabcontent p-1">
                <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.frontEndSettings.updateServices') }}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Header Image</label>
                      <input name="header_image" class="form-control" id="header_image" type="file" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Title Ar</label>
                      <input name="title_ar" class="form-control" value="{{ old('title_ar')?old('title_ar'):$data->getTranslation('title','ar') }}" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Title En</label>
                      <input name="title_en" class="form-control" value="{{ old('title_en')?old('title_en'):$data->getTranslation('title','en') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description ar</label>
                   
                      <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar')?$data->getTranslation('description','ar'):$data->getTranslation('description','ar') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Description En</label>
                      <textarea name="description_en" class="form-control" rows="3">{{ old('description_en')?$data->getTranslation('description','en'):$data->getTranslation('description','en') }}</textarea>
                    </div>

                    <div class="form-group mt-2">
                        <div class="text-left">
                            <h4><span class="badge">First Section</span></h4>
                          </div>      
                        <hr />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title Ar</label>
                        <input name="title_ar_section_one" class="form-control" value="{{ old('title_ar_section_one')?old('title_ar_section_one'):$data->contentData?->title_ar_section_one }}" />
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Title En</label>
                        <input name="title_en_section_one" class="form-control" value="{{ old('title_en_section_one')?old('title_en'):$data->contentData?->title_en_section_one }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description ar</label>
                     
                        <textarea name="description_ar_section_one" class="form-control" rows="3">{{ old('description_ar_section_one')?old('description_ar_section_one'):$data->contentData?->description_ar_section_one }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Description En</label>
                        <textarea name="description_en_section_one" class="form-control" rows="3">{{ old('description_en_section_one')?old('description_ar_section_one'):$data->contentData?->description_en_section_one }}</textarea>
                      </div>
                    <div class="form-group mt-2">
                        <div class="text-left">
                            <h4><span class="badge">Second Section</span></h4>
                          </div>      
                        <hr />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image #1</label>
                        <input name="second_section_image_one" class="form-control" id="second_section_image_one" type="file" />
                      </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image #2</label>
                        <input name="second_section_image_two" class="form-control" id="second_section_image_two" type="file" />
                      </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title Ar</label>
                        <input name="title_ar_section_two" class="form-control" value="{{ old('title_ar_section_two')?old('title_ar_section_two'):$data->contentData?->title_ar_section_two }}" />
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Title En</label>
                        <input name="title_en" class="form-control" value="{{ old('title_en')?old('title_en'):$data->contentData?->title_ar_section_two }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description ar</label>
                     
                        <textarea name="description_ar_section_two" class="form-control" rows="3">{{ old('description_ar_section_two')?old('description_ar_section_two'):$data->contentData?->description_ar_section_two }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Description En</label>
                        <textarea name="description_en_section_two" class="form-control" rows="3">{{ old('description_en_section_two')?old('description_en_section_two'):$data->contentData?->description_en_section_two }}</textarea>
                      </div>
                      <div class="form-group mt-2">
                        <div class="text-left">
                            <h4><span class="badge">Cards</span></h4>
                          </div>      
                        <hr />
                    </div>

                    <div>

                        <!-- Start -->
                        <div>
                            <h3>
                                Card #1
                            </h3>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title En</label>
                                <input name="card_one_title_en" class="form-control" value="{{ old('card_one_title_en')?old('card_one_title_en'):$data->contentData?->card_one_title_en }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title Ar</label>
                                <input name="card_one_title_ar" class="form-control" value="{{ old('card_one_title_ar')?old('card_one_title_ar'):$data->contentData?->card_one_title_ar }}">
                            </div>

                            <label for="exampleInputPassword1">Description En</label>
                            <textarea name="card_one_description_en" class="form-control" rows="3">{{ old('card_one_description_en')?old('card_one_description_en'):$data->contentData?->card_one_description_en }}</textarea>
                            <label for="exampleInputPassword1">Description Ar</label>
                            <textarea name="card_one_description_ar" class="form-control" rows="3">{{ old('card_one_description_ar')?old('card_one_description_ar'):$data->contentData?->card_one_description_ar }}</textarea>
    

                        </div>
                        <!-- Start -->
                        <div class="mt-2">
                            <h3>
                                Card #2
                            </h3>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title En</label>
                               
                                <input name="card_two_title_en" class="form-control" value="{{ old('card_two_title_en')?old('card_two_title_en'):$data->contentData?->card_two_title_en }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title Ar</label>
                                <input name="card_two_title_ar" class="form-control" value="{{ old('card_two_title_ar')?old('card_two_title_ar'):$data->contentData?->card_two_title_ar }}">
                            </div>

                            <label for="exampleInputPassword1">Description En</label>
                            <textarea name="card_two_description_en" class="form-control" rows="3">{{ old('card_two_description_en')?old('card_two_description_en'):$data->contentData?->card_two_description_en }}</textarea>
                            <label for="exampleInputPassword1">Description Ar</label>
                            <textarea name="card_two_description_ar" class="form-control" rows="3">{{ old('card_two_description_ar')?old('card_two_description_ar'):$data->contentData?->card_two_description_ar }}</textarea>
    

                        </div>
                        <!-- Start -->
                        <div class="mt-2">
                            <h3>
                                Card #3
                            </h3>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title En</label>
                                <input name="card_three_title_en" class="form-control" value="{{ old('card_three_title_en')?old('card_three_title_en'):$data->contentData?->card_three_title_en }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title Ar</label>
                                <input name="card_three_title_ar" class="form-control" value="{{ old('card_three_title_ar')?old('card_three_title_ar'):$data->contentData?->card_three_title_ar }}">
                            </div>

                            <label for="exampleInputPassword1">Description En</label>
                            <textarea name="card_three_description_en" class="form-control" rows="3">{{ old('card_three_description_en')?old('card_three_description_en'):$data->contentData?->card_three_description_en }}</textarea>
                            <label for="exampleInputPassword1">Description Ar</label>
                            <textarea name="card_three_description_ar" class="form-control" rows="3">{{ old('card_three_description_ar')?old('card_three_description_ar'):$data->contentData?->card_three_description_ar }}</textarea>
    

                        </div>
                        <!-- Start -->
                        <div class="mt-2">
                            <h3>
                                Card #4
                            </h3>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title En</label>
                                <input name="card_four_title_en" class="form-control" value="{{ old('card_four_title_en')?old('card_four_title_en'):$data->contentData?->card_four_title_en }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Title Ar</label>
                                <input name="card_four_title_ar" class="form-control" value="{{ old('card_four_title_ar')?old('card_four_title_ar'):$data->contentData?->card_four_title_ar }}">
                            </div>

                            <label for="exampleInputPassword1">Description En</label>
                            <textarea name="card_four_description_en" class="form-control" rows="3">{{ old('card_four_description_en')?old('card_four_description_en'):$data->contentData?->card_four_description_en }}</textarea>
                            <label for="exampleInputPassword1">Description Ar</label>
                            <textarea name="card_four_description_ar" class="form-control" rows="3">{{ old('card_four_description_ar')?old('card_four_description_ar'):$data->contentData?->card_four_description_ar }}</textarea>
    

                        </div>

                        <div class="form-group mt-2">
                            <div class="text-left">
                                <h4><span class="badge">Video Section</span></h4>
                              </div>      
                            <hr />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Video</label>
                            <input type="file" name="main_video_video_section" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Background Video Image</label>
                            <input type="file" name="back_ground_video_image" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title En</label>
                            <input value='{{ old('video_section_title_en')?old('video_section_title_en'):$data->contentData?->video_section_title_en }}' type="text" name="video_section_title_en" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title Ar</label>
                            <input value='{{ old('video_section_title_ar')?old('video_section_title_ar'):$data->contentData?->video_section_title_ar }}' type="text" name="video_section_title_ar" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description En</label>
                            <textarea name="video_section_description_en" class="form-control" rows="3">{{ old('video_section_description_en')?old('video_section_description_en'):$data->contentData?->video_section_description_en }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description Ar</label>
                            <textarea name="video_section_description_ar" class="form-control" rows="3">{{ old('video_section_description_ar')?old('video_section_description_ar'):$data->contentData?->video_section_description_ar }}</textarea>
                        </div>
                      



                    </div>

                  
                      <!-- -->
                  </div>





                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                  
              </div>
           

          </div>
    </div>
</div>