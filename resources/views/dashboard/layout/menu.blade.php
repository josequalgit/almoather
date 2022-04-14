<style>
    .logo{
        /* width: 80px !important;
         height: 76px !important; */
    }
    li.nav-item.mr-auto {
        margin: 0 auto !important;
    }
    .main-menu .navbar-header .navbar-brand .brand-logo .logo {
        height: 92px;
        display: flex;
        position: relative;
        left: -34px;
        bottom: 22%;
    }
    .marginFromLogo{
        margin-top: 25%;
    }
    .main-menu.menu-light .navigation > li.active:not(.sidebar-group-active) > a {
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    }
.breadcrumb-item.active {
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.bx-edit{
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.bx-show{
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.bx-broadcast{
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.nav-item.hover.open{
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.dropdown-item:active {
    border-radius: 0.267rem;
    background-image: linear-gradient( to right, #bc6428, #ffd77a, #945825 ) !important;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

    .logButton{
      background-image: linear-gradient(
        to right,
        #bc6428,
        #ffd77a,
        #945825
    ) !important;
    border: none !important;
    }

    textarea:focus,select , select:active , select:hover ,input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-    input:focus {
    border-color: none;
    box-shadow: none;
    -webkit-box-shadow: none;
    outline: #ffd77a auto 5px;
}
option:not(:checked) { 
    border-color: none;
    box-shadow: none;
    -webkit-box-shadow: none;
    outline: #ffd77a auto 5px;
}
.form-check-input:not(:checked){
    background: red;
}
.checkbox {
  padding-left: 20px;
}
.checkbox label {
  display: inline-block;
  vertical-align: middle;
  position: relative;
  padding-left: 5px;
}
.checkbox label::before {
  content: "";
  display: inline-block;
  position: absolute;
  width: 17px;
  height: 17px;
  left: 0;
  margin-left: -20px;
  border: 1px solid #cccccc;
  border-radius: 3px;
  background-color: #fff;
  -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
  -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
  transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
}
.checkbox label::after {
  display: inline-block;
  position: absolute;
  width: 16px;
  height: 16px;
  left: 0;
  top: 0;
  margin-left: -20px;
  padding-left: 3px;
  padding-top: 1px;
  font-size: 11px;
  color: #555555;
}
.checkbox input[type="checkbox"],
.checkbox input[type="radio"] {
  opacity: 0;
  z-index: 1;
}
.checkbox input[type="checkbox"]:focus + label::before,
.checkbox input[type="radio"]:focus + label::before {
  outline: thin dotted;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}
.checkbox input[type="checkbox"]:checked + label::after,
.checkbox input[type="radio"]:checked + label::after {
  font-family: "FontAwesome";
  content: "\f00c";
}
.checkbox input[type="checkbox"]:disabled + label,
.checkbox input[type="radio"]:disabled + label {
  opacity: 0.65;
}
.checkbox input[type="checkbox"]:disabled + label::before,
.checkbox input[type="radio"]:disabled + label::before {
  background-color: #eeeeee;
  cursor: not-allowed;
}
.checkbox.checkbox-circle label::before {
  border-radius: 50%;
}
.checkbox.checkbox-inline {
  margin-top: 0;
}

.checkbox-primary input[type="checkbox"]:checked + label::before,
.checkbox-primary input[type="radio"]:checked + label::before {
  background-color: #337ab7;
  border-color: #337ab7;
}
.checkbox-primary input[type="checkbox"]:checked + label::after,
.checkbox-primary input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-danger input[type="checkbox"]:checked + label::before,
.checkbox-danger input[type="radio"]:checked + label::before {
  background-color: #d9534f;
  border-color: #d9534f;
}
.checkbox-danger input[type="checkbox"]:checked + label::after,
.checkbox-danger input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-info input[type="checkbox"]:checked + label::before,
.checkbox-info input[type="radio"]:checked + label::before {
  background-color: #5bc0de;
  border-color: #5bc0de;
}
.checkbox-info input[type="checkbox"]:checked + label::after,
.checkbox-info input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-warning input[type="checkbox"]:checked + label::before,
.checkbox-warning input[type="radio"]:checked + label::before {
  background-color: #f0ad4e;
  border-color: #f0ad4e;
}
.checkbox-warning input[type="checkbox"]:checked + label::after,
.checkbox-warning input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox-success input[type="checkbox"]:checked + label::before,
.checkbox-success input[type="radio"]:checked + label::before {
  background-color: #5cb85c;
  border-color: #5cb85c;
}
.checkbox-success input[type="checkbox"]:checked + label::after,
.checkbox-success input[type="radio"]:checked + label::after {
  color: #fff;
}

.checkbox.checkbox-sm label::before {
  width: 30px;
  height: 30px;
  top: -13px;
}
.checkbox.checkbox-sm label::after {
  width: 30px;
  height: 30px;
  padding-left: 4px;
  font-size: 20px;
  left: 1px;
  top: -13px;
}
.checkbox.checkbox-sm label {
  padding-left: 18px;
  top: 13px;
}
.checkbox.checkbox-md label::before {
  width: 34px;
  height: 34px;
  top: -17px;
}
.checkbox.checkbox-md label::after {
  width: 34px;
  height: 34px;
  padding-left: 4px;
  font-size: 24px;
  left: 1px;
  top: -18px;
}
.checkbox.checkbox-md label {
  padding-left: 22px;
  top: 17px;
}
.checkbox.checkbox-lg label::before {
  width: 46px;
  height: 46px;
  top: -28px;
}
.checkbox.checkbox-lg label::after {
  width: 46px;
  height: 46px;
  padding-left: 4px;
  font-size: 36px;
  left: 1px;
  top: -31px;
}
.checkbox.checkbox-lg label {
  padding-left: 34px;
  top: 32px;
}

.radio {
  padding-left: 20px;
}
.radio label {
  display: inline-block;
  vertical-align: middle;
  position: relative;
  padding-left: 5px;
}
.radio label::before {
  content: "";
  display: inline-block;
  position: absolute;
  width: 17px;
  height: 17px;
  left: 0;
  margin-left: -20px;
  border: 1px solid #cccccc;
  border-radius: 50%;
  background-color: #fff;
  -webkit-transition: border 0.15s ease-in-out;
  -o-transition: border 0.15s ease-in-out;
  transition: border 0.15s ease-in-out;
}
.radio label::after {
  display: inline-block;
  position: absolute;
  content: " ";
  width: 11px;
  height: 11px;
  left: 3px;
  top: 3px;
  margin-left: -20px;
  border-radius: 50%;
  background-color: #555555;
  -webkit-transform: scale(0, 0);
  -ms-transform: scale(0, 0);
  -o-transform: scale(0, 0);
  transform: scale(0, 0);
  -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
}
.radio input[type="radio"] {
  opacity: 0;
  z-index: 1;
}
.radio input[type="radio"]:focus + label::before {
  outline: thin dotted;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}
.radio input[type="radio"]:checked + label::after {
  -webkit-transform: scale(1, 1);
  -ms-transform: scale(1, 1);
  -o-transform: scale(1, 1);
  transform: scale(1, 1);
}
.radio input[type="radio"]:disabled + label {
  opacity: 0.65;
}
.radio input[type="radio"]:disabled + label::before {
  cursor: not-allowed;
}
.radio.radio-inline {
  margin-top: 0;
}

.radio-primary input[type="radio"] + label::after {
  background-color: #337ab7;
}
.radio-primary input[type="radio"]:checked + label::before {
  border-color: #337ab7;
}
.radio-primary input[type="radio"]:checked + label::after {
  background-color: #337ab7;
}

.radio-danger input[type="radio"] + label::after {
  background-color: #d9534f;
}
.radio-danger input[type="radio"]:checked + label::before {
  border-color: #d9534f;
}
.radio-danger input[type="radio"]:checked + label::after {
  background-color: #d9534f;
}

.radio-info input[type="radio"] + label::after {
  background-color: #5bc0de;
}
.radio-info input[type="radio"]:checked + label::before {
  border-color: #5bc0de;
}
.radio-info input[type="radio"]:checked + label::after {
  background-color: #5bc0de;
}

.radio-warning input[type="radio"] + label::after {
  background-color: #f0ad4e;
}
.radio-warning input[type="radio"]:checked + label::before {
  border-color: #f0ad4e;
}
.radio-warning input[type="radio"]:checked + label::after {
  background-color: #f0ad4e;
}

.radio-success input[type="radio"] + label::after {
  background-color: #5cb85c;
}
.radio-success input[type="radio"]:checked + label::before {
  border-color: #5cb85c;
}
.radio-success input[type="radio"]:checked + label::after {
  background-color: #5cb85c;
}

input[type="checkbox"].styled:checked + label:after,
input[type="radio"].styled:checked + label:after {
  font-family: 'FontAwesome';
  content: "\f00c";
}
input[type="checkbox"] .styled:checked + label::before,
input[type="radio"] .styled:checked + label::before {
  color: #fff;
}
input[type="checkbox"] .styled:checked + label::after,
input[type="radio"] .styled:checked + label::after {
  color: #fff;
}

.radio.radio-sm label::before {
  width: 30px;
  height: 30px;
  top: -13px;
}
.radio.radio-sm label::after {
  width: 22px;
  height: 22px;
  padding-left: 4px;
  font-size: 20px;
  left: 4px;
  top: -9px;
}
.radio.radio-sm label {
  padding-left: 18px;
  top: 13px;
}
.radio.radio-md label::before {
  width: 34px;
  height: 34px;
  top: -17px;
}
.radio.radio-md label::after {
  width: 26px;
  height: 26px;
  padding-left: 4px;
  font-size: 24px;
  left: 4px;
  top: -13px;
}
.radio.radio-md label {
  padding-left: 22px;
  top: 17px;
}
.radio.radio-lg label::before {
  width: 46px;
  height: 46px;
  top: -28px;
}
.radio.radio-lg label::after {
  width: 36px;
  height: 36px;
  padding-left: 4px;
  font-size: 36px;
  left: 5px;
  top: -23px;
}
.radio.radio-lg label {
  padding-left: 34px;
  top: 32px;
}
.main-menu.menu-light .navigation {
    background: none;
}
.vertical-layout.vertical-menu-modern.menu-expanded .main-menu {
    background: #fff;
}

.menu-toggle::after {
    content: "";
    position: absolute;
    top: 50%;
    display: block;
    width: 0.45em;
    height: 0.45em;
    border: 1.5px solid;
    border-bottom: 0;
    border-left: 0;
    transform: translateY(-50%) rotate(45deg);
    margin-left: 84%;
}
.menu-vertical .menu-item .menu-toggle::after {
    right: 0.938rem;
}
.menu:not(.menu-no-animation) .menu-toggle::after {
    transition-duration: 0.3s;
    transition-property: transform;
}
.menu-vertical .menu-item .menu-toggle {
    padding-right: calc(0.938rem + 1.35em);
}
.menu-vertical .menu-item .menu-link {
    font-size: 0.9375rem;
}
.menu-vertical .menu-item .menu-link, .menu-vertical .menu-block {
    padding: 0.625rem 0.938rem;
}
.menu:not(.menu-no-animation) .menu-link {
    transition-duration: 0.3s;
    transition-property: color, background-color;
}
.bg-menu-theme .menu-link, .bg-menu-theme .menu-horizontal-prev, .bg-menu-theme .menu-horizontal-next {
    color: #677788;
}
.menu-link {
    position: relative;
    display: flex;
    align-items: center;
    flex: 0 1 auto;
    margin: 0;
}

.deleteIcon {
  color:#ffff;
}



</style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}">
                    <div class="brand-logo">
                        {{-- <svg class="logo" width="26px" height="26px" viewbox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>icon</title>
                            <defs>
                                <lineargradient id="linearGradient-1" x1="50%" y1="0%" x2="50%" y2="100%">
                                    <stop stop-color="#5A8DEE" offset="0%"></stop>
                                    <stop stop-color="#699AF9" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop stop-color="#FDAC41" offset="0%"></stop>
                                    <stop stop-color="#E38100" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Sprite" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="sprite" transform="translate(-69.000000, -61.000000)">
                                    <g id="Group" transform="translate(17.000000, 15.000000)">
                                        <g id="icon" transform="translate(52.000000, 46.000000)">
                                            <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z"></path>
                                            <path id="Combined-Shape" d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5378966 4.74673291,13.1939746 4.7846258,12.8556254 L8.55057141,12.8560055 C8.48653249,13.1896162 8.45300462,13.5340745 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.529522,8.45300462 13.180715,8.48740462 12.8430777,8.55306931 L12.8426531,4.78608796 C13.1851829,4.7472336 13.5334422,4.72727273 13.8863636,4.72727273 Z" fill="#4880EA"></path>
                                            <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z" fill="url(#linearGradient-1)"></path>
                                            <rect id="Rectangle" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                            <rect id="Rectangle" fill="url(#linearGradient-2)" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg> --}}
                        <img class="logo" src="{{ asset('main2/images/logo/logo.png') }}" />

                    </div>
                    {{-- <img width="150px" src="{{ asset('FrontEnd/images/Logo.png') }}" /> --}}

                    {{-- <h2 class="brand-text mb-0">Frest</h2> --}}
                </a></li>
            {{-- <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li> --}}
        </ul>
    </div>
    @php
    $checkStatus = array_key_exists("status", request()->route()->parameters);
    $route = Route::current();
    $name = $route->getName();
    $para = $checkStatus ? request()->route()->parameters['status'] : null;
    $role = Auth::user()->roles[0]->name
    @endphp
    <div class="shadow-bottom"></div>
    <div class="main-menu-content marginFromLogo">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
          @if($role == 'superAdmin')
            <li class="">
                <a href=""><i class="bx bx-home" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            
          @endif
          <li class=" navigation-header text-truncate"><span data-i18n="Apps">Sections</span>
          </li>
           {{-- @php
               dd(Auth::user()->roles[0]->name);
           @endphp --}}
           {{-- @if($role !== 'Contracts Manager') --}}
           @if($role == 'superAdmin')
            @canany(['Edit Admin','Create Admin','See Admin','Delete Admin','Edit Role','Create Role','See Role','Delete Role'])
            {{-- <li class="{{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.admins.index') }}"><i class="bx bx-user"></i><span class="menu-title text-truncate" data-i18n="admins">Admins</span></a>
            </li> --}}


            <li class="menu-item  {{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Invoice">System Users</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
                @canany(['Edit Admin','Create Admin','See Admin','Delete Admin'])

                <li class="menu-item
                {{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.admins.index') }}" class="menu-link">
                    <div data-i18n="List">Admins</div>
                  </a>
                </li>
                @endcanany
               
                @canany(['Edit Role','Create Role','See Role','Delete Role'])
                <li class="menu-item
                {{ ($name == 'dashboard.roles.index'|| $name == 'dashboard.roles.create'|| $name == 'dashboard.roles.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.roles.index') }}" class="menu-link">
                    <div data-i18n="List">Roles</div>
                  </a>
                </li>
                @endcanany
            
              </ul>
            </li>




            @endcanany

            @canany(['Edit Influncer','Create Influncer','See Influncer','Delete Influncer','Edit Customer','Create Customer','See Customer','Delete Customer'])
            {{-- <li class="{{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.admins.index') }}"><i class="bx bx-user"></i><span class="menu-title text-truncate" data-i18n="admins">Admins</span></a>
            </li> --}}


            <li class="menu-item  {{ ($name == 'dashboard.influncers.index'|| $name == 'dashboard.influncers.create'|| $name == 'dashboard.influncers.edit'||$name == 'dashboard.customers.index'||$name == 'dashboard.customers.edit'||$name == 'dashboard.customers.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Invoice">App Users</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-5 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
               
                @canany(['Edit Influncer','Create Influncer','See Influncer','Delete Influncer'])
                <li class="menu-item
                {{ ($name == 'dashboard.influncers.index'|| $name == 'dashboard.influncers.create'|| $name == 'dashboard.influncers.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.influncers.index') }}" class="menu-link">
                    <div data-i18n="List">Influncers</div>
                  </a>
                </li>
                @endcanany
                @canany(['Edit Customer','Create Customer','See Customer','Delete Customer'])
                <li class="menu-item
                {{ ($name == 'dashboard.customers.index'|| $name == 'dashboard.customers.create'|| $name == 'dashboard.customers.edit'|| $name == 'dashboard.customers.showAds')  ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.customers.index') }}" class="menu-link">
                    <div data-i18n="List">Customers</div>
                  </a>
                </li>
                @endcanany
            
              </ul>
            </li>




            @endcanany
            {{-- @canany(['Edit Influncer','Create Influncer','See Influncer','Delete Influncer'])
            <li class="{{ ($name == 'dashboard.influncers.index'|| $name == 'dashboard.influncers.create'|| $name == 'dashboard.influncers.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.influncers.index') }}"><i class="bx bx-user-pin"></i><span class="menu-title text-truncate" data-i18n="influncers">Influncers</span></a>
            </li>
            @endcanany --}}
            {{-- @canany(['Edit Customer','Create Customer','See Customer','Delete Customer'])
            <li class="{{ ($name == 'dashboard.customers.index'|| $name == 'dashboard.customers.create'|| $name == 'dashboard.customers.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.customers.index') }}"><i class="bx bx-user-circle"></i><span class="menu-title text-truncate" data-i18n="influncers">Customers</span></a>
            </li>
            @endcanany --}}
            {{-- @canany(['Edit Role','Create Role','See Role','Delete Role'])
            <li class="{{ ($name == 'dashboard.roles.index'|| $name == 'dashboard.roles.create'|| $name == 'dashboard.roles.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.roles.index') }}"><i class="bx bx-lock"></i><span class="menu-title text-truncate" data-i18n="roles">Roles</span></a>
            </li>
            @endcanany --}}
            @canany(['Edit Notification','Create Notification','See Notification','Delete Notification'])
            <li class="{{ ($name == 'dashboard.notifications.index'|| $name == 'dashboard.notifications.create'|| $name == 'dashboard.notifications.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.notifications.index') }}"><i class="bx bx-bell"></i><span class="menu-title text-truncate" data-i18n="notifications">Notifications</span></a>
            </li>
            @endcanany
            @canany(['Edit Campaign Goal','Create Campaign Goal','See Campaign Goal','Delete Campaign Goal'])
            <li class="{{ ($name == 'dashboard.campaignGoals.index'|| $name == 'dashboard.campaignGoals.create'|| $name == 'dashboard.campaignGoals.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.campaignGoals.index') }}"><i class="bx bx-bullseye"></i><span class="menu-title text-truncate" data-i18n="campaignGoals">Campaign Goal</span></a>
            </li>
            @endcanany
            @canany(['Edit Ads','Create Ads','See Ads','Delete Ads'])
           
            <li class="menu-item  {{ ($name == 'dashboard.ads.index'|| $name == 'dashboard.ads.create'|| $name == 'dashboard.ads.edit') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Invoice">Ads</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
                {{-- <li class="nav-item"><a ><span class="menu-title text-truncate" data-i18n="ads">Ads</span></a>
                </li> --}}
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == null)|| ($name == 'dashboard.ads.create'&&$para == null)||($name == 'dashboard.ads.edit')&&$para == null) ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index') }}" class="menu-link">
                    <div data-i18n="List">All</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'pending')|| ($name == 'dashboard.ads.create'&&$para == 'pending')||($name == 'dashboard.ads.edit')&&$para == 'pending') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','pending') }}" class="menu-link">
                    <div data-i18n="List">Pending</div>
                  </a>
                </li>
                <li class="menu-item 
                {{ (($name == 'dashboard.ads.index'&&$para == 'APPROVE')|| ($name == 'dashboard.ads.create'&&$para == 'APPROVE')||($name == 'dashboard.ads.edit')&&$para == 'APPROVE') ? 'active':''  }}">
                  <a href="{{ route('dashboard.ads.index','APPROVE') }}" class="menu-link">
                    <div data-i18n="List">Approved</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'prepay')|| ($name == 'dashboard.ads.create'&&$para == 'prepay')||($name == 'dashboard.ads.edit')&&$para == 'prepay') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','prepay') }}" class="menu-link">
                    <div data-i18n="List">Pre Pay</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'fullpayment')|| ($name == 'dashboard.ads.create'&&$para == 'fullpayment')||($name == 'dashboard.ads.edit')&&$para == 'fullpayment') ? 'active':''  }}

                ">
                  <a href="{{ route('dashboard.ads.index','fullpayment') }}" class="menu-link">
                    <div data-i18n="List">Full Payment</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'progress')|| ($name == 'dashboard.ads.create'&&$para == 'progress')||($name == 'dashboard.ads.edit')&&$para == 'progress') ? 'active':''  }}

                ">
                  <a href="{{ route('dashboard.ads.index','progress') }}" class="menu-link">
                    <div data-i18n="List">Progress</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'influncer_complete')|| ($name == 'dashboard.ads.create'&&$para == 'influncer_complete')||($name == 'dashboard.ads.edit')&&$para == 'influncer_complete') ? 'active':''  }}

                ">
                  <a href="{{ route('dashboard.ads.index','influncer_complete') }}" class="menu-link">
                    <div data-i18n="List">Influncer Complete</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'complete')|| ($name == 'dashboard.ads.create'&&$para == 'complete')||($name == 'dashboard.ads.edit')&&$para == 'complete') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','complete') }}" class="menu-link">
                    <div data-i18n="List">Complete</div>
                  </a>
                </li>
                {{-- <li class="menu-item">
                  <a href="app-invoice-preview.html" class="menu-link">
                    <div data-i18n="Preview">Preview</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-invoice-edit.html" class="menu-link">
                    <div data-i18n="Edit">Edit</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-invoice-add.html" class="menu-link">
                    <div data-i18n="Add">Add</div>
                  </a>
                </li> --}}
              </ul>
            </li>
            @endcanany
         
            @canany(['Edit Category','Create Category','See Category','Delete Category','Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])

            <li class="menu-item  {{ ($name == 'dashboard.categories.index'|| $name == 'dashboard.categories.create'|| $name == 'dashboard.categories.edit'||$name == 'dashboard.influencerCategories.index'||$name == 'dashboard.influencerCategories.edit'||$name == 'dashboard.influencerCategories.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Invoice">Categories</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
               
                @canany(['Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.influencerCategories.index'|| $name == 'dashboard.influencerCategories.create'|| $name == 'dashboard.influencerCategories.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.influencerCategories.index') }}" class="menu-link">
                    <div data-i18n="List">Infulncer</div>
                  </a>
                </li>
                @endcanany
                @canany(['Edit Category','Create Category','See Category','Delete Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.categories.index'|| $name == 'dashboard.categories.create'|| $name == 'dashboard.categories.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.categories.index') }}" class="menu-link">
                    <div data-i18n="List">Product</div>
                  </a>
                </li>
                @endcanany
            
              </ul>
            </li>

            @endcanany
           
            
            @canany(['Edit SocialMedia','Create SocialMedia','See SocialMedia','Delete SocialMedia'])

            <li class="menu-item  {{ ($name == 'dashboard.socialMedia.index'|| $name == 'dashboard.socialMedia.create'|| $name == 'dashboard.socialMedia.edit'||$name == 'dashboard.faqs.index'||$name == 'dashboard.faqs.edit'||$name == 'dashboard.faqs.create'||$name == 'dashboard.editContactUs.index'||$name == 'dashboard.editContactUs.edit'||$name == 'dashboard.editContactUs.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-slider"></i>
                <div data-i18n="Invoice">Settings</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
               
                @canany(['Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.faqs.index'|| $name == 'dashboard.faqs.create'|| $name == 'dashboard.faqs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.faqs.index') }}" class="menu-link">
                    <div data-i18n="List">Faqs</div>
                  </a>
                </li>
                @endcanany
                @canany(['Contact Us'])
                <li class="menu-item
                {{ ($name == 'dashboard.contactUs.index'|| $name == 'dashboard.contactUs.create'|| $name == 'dashboard.contactUs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contactUs.index') }}" class="menu-link">
                    <div data-i18n="List">Settings</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit SocialMedias','Create SocialMedia','See SocialMedia'])
                <li class="menu-item
                {{ ($name == 'dashboard.socialMedia.index'|| $name == 'dashboard.socialMedia.create'|| $name == 'dashboard.socialMedia.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.socialMedia.index') }}" class="menu-link">
                    <div data-i18n="List">Social Media</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit Contact Us'])
                <li class="menu-item
                {{ ($name == 'dashboard.contactUs.index'|| $name == 'dashboard.contactUs.create'|| $name == 'dashboard.contactUs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contactUs.edit') }}" class="menu-link">
                    <div data-i18n="List">Settings</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit Slide','Create Slide','See Slide'])
                <li class="menu-item
                {{ ($name == 'dashboard.slides.index'|| $name == 'dashboard.slides.create'|| $name == 'dashboard.slides.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.slides.index') }}" class="menu-link">
                    <div data-i18n="List">Slides</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit Contract','Create Contract','See Contract'])
                <li class="menu-item
                {{ ($name == 'dashboard.contracts.index'|| $name == 'dashboard.contracts.create'|| $name == 'dashboard.contracts.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contracts.edit') }}" class="menu-link">
                    <div data-i18n="List">Contract</div>
                  </a>
                </li>
                @endcanany

                {{-- @canany(['Add Campaign Goal','Delete Campaign Goal','Edit Campaign Goal'])
                <li class="menu-item
                {{ ($name == 'dashboard.campaignGoals.index'|| $name == 'dashboard.campaignGoals.create'|| $name == 'dashboard.campaignGoals.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.campaignGoals.index') }}" class="menu-link">
                    <div data-i18n="List">Campaign Goal</div>
                  </a>
                </li>
                @endcanany --}}
            
              </ul>
            </li>



            {{-- <li class="{{ ($name == 'dashboard.socialMedia.index'|| $name == 'dashboard.socialMedia.create'|| $name == 'dashboard.socialMedia.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.socialMedia.index') }}"><i class="bx bx-share-alt"></i><span class="menu-title text-truncate" data-i18n="categories">Social Media</span></a>
            </li> --}}

            @endcanany
            {{-- @canany(['Edit Faq','Create Faq','See Faq','Delete Faq'])
            <li class="{{ ($name == 'dashboard.faqs.index'|| $name == 'dashboard.faqs.create'|| $name == 'dashboard.faqs.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.faqs.index') }}"><i class="bx bx-question-mark"></i><span class="menu-title text-truncate" data-i18n="categories">Faq</span></a>
            </li>
            @endcanany
            @can('Edit Contact Us')
            <li class="{{ ($name == 'dashboard.contactUs.index'|| $name == 'dashboard.contactUs.create'|| $name == 'dashboard.contactUs.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.contactUs.edit') }}"><i class="bx bx-slider"></i><span class="menu-title text-truncate" data-i18n="editContactUs">Settings</span></a>
            </li>
            @endcan            --}}
            @can('See Logs')
            <li class="{{ ($name == 'dashboard.logs.index'|| $name == 'dashboard.logs.create'|| $name == 'dashboard.logs.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.logs.index') }}"><i class="bx bx-code-block"></i><span class="menu-title text-truncate" data-i18n="logs">Logs</span></a>
            </li>
            @endcan
           
            @elseif($role == 'Contracts Manager')
            <li class="{{ ($name == 'dashboard.contracts.activeContract') ? 'active':''  }}">
              <a href="{{route('dashboard.contracts.activeContract')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Influncers Contracts</span></a>
           </li>
            <li class="{{ ($name == 'dashboard.contracts.customerContracts') ? 'active':''  }}">
              <a href="{{route('dashboard.contracts.customerContracts')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Customers Contracts</span></a>
           </li>
           
            <li class="{{ ($name == 'dashboard.influncers.allInfluncerWithViews') ? 'active':''  }}">
              <a href="{{route('dashboard.influncers.allInfluncerWithViews')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Influncers</span></a>
           </li>
            @endif
         
        </ul>
    </div>
</div>