@extends('dashboard.layout.index')
@section('content')
<style>
    /* .tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  height: 300px;
} */

/* Style the buttons inside the tab */
.tab a {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab a:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab a.active {
    background-color: #bb9355;
    color: #fff;
    font-weight: bold;
}
.tab a {
  background-color:#8e8ab0;
  color: #fff;
    font-weight: bold;
}

/* Style the tab content */
.tabcontent {
  /* float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 70%;
  border-left: none;
  height: 300px; */
  border-width: 1px;
}
.tablinks{
    
    color: #fff;
    border-radius: 15px;
    background: #ffdfaf;

}
</style>
<div class="app-content content">

<div class="content-overlay"></div>
<div class="content-wrapper">
 
    <div class="content-body">
        <!-- Basic tabs start -->
        <section id="basic-datatable">
            <div class="row">
                <div class="col-lg-2 col-md-4 pr-0">
                    <div class="tab mb-1 rounded">
                     
                        @foreach ($tabNames as $item)
                            <a class="tablinks mb-2 {{ $item['type'] == $type?'active':'' }}" href="{{ route('dashboard.frontEndSettings.index',$item['type']) }}">{{$item['title'] }}</a>                        
                        @endforeach
                      </div>
                </div>
                <div class="col-lg-9 col-md-8">
                  @if($type == 'welcome_page')
                  @include('dashboard.frontEndSetting.include.welcomeMessage')
                  @elseif($type == 'about_us')
                  @include('dashboard.frontEndSetting.include.about_us')
                  @elseif($type == 'faq')
                  @include('dashboard.frontEndSetting.include.faq')
                  @elseif($type == 'contact_info')
                  @include('dashboard.frontEndSetting.include.contactUs')
                  @elseif($type == 'website_description')
                  @include('dashboard.frontEndSetting.include.website_description')
                  @elseif($type == 'login_text')
                  @include('dashboard.frontEndSetting.include.login')
                  @elseif($type == 'register_type')
                  @include('dashboard.frontEndSetting.include.register_type')
                  @elseif($type == 'get_touch')
                  @include('dashboard.frontEndSetting.include.get_touch')
                  @elseif($type == 'location')
                  @include('dashboard.frontEndSetting.include.location')
                  @elseif($type == 'our-services')
                  @include('dashboard.frontEndSetting.include.ourservice')
                  @endif
                </div>
            </div>
        </section>
    </div>
</div>
</div>



      
</div>


@endsection

@section('scripts')
<script>
     $('#tab2').hide();
    $('#tab3').hide();
     CKEDITOR.replace('text_ar', {
      extraPlugins: 'placeholder',
      height: 220,
      removeButtons: 'PasteFromWord'
    });
     CKEDITOR.replace('text_en', {
      extraPlugins: 'placeholder',
      height: 220,
      removeButtons: 'PasteFromWord'
    });
  

   

// Get the element with id="defaultOpen" and click on it
// document.getElementById("defaultOpen").click();

</script>
@endsection