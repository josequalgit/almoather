<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Al Muaathir Dashboard</title>
    <link rel="apple-touch-icon" href="{{ asset('main2/images/ico/apple-icon-120.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('main2/images/logo/logo.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/videopopup.css') }}">
    <!-- END: Theme CSS-->


    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/core/menu/menu-types/vertical-menu.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <style>
        .table-longText{
            overflow: hidden;
            width:100px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .select2-container{
    width: 100% !important;
}
.select2-selection--multiple .select2-selection__choice__display {
    padding-left: 13px !important;
}
.pagination .page-item.active .page-link, .pagination .page-item.active .page-link:hover {
    border-radius: 0.267rem;
    background-color: #475f7b !important;
    color: #fbd075;
}
    </style>

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                        {{-- <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon bx bx-check-circle"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                                <div class="bookmark-input search-input">
                                    <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                                    <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">
                                    <ul class="search-list"></ul>
                                </div>
                            </li>
                        </ul> --}}
                    </div>
                    <ul class="nav navbar-nav float-right">
                        {{-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="javascript:void(0);" data-language="en"><i class="flag-icon flag-icon-us mr-50"></i> English</a><a class="dropdown-item" href="javascript:void(0);" data-language="fr"><i class="flag-icon flag-icon-fr mr-50"></i> French</a><a class="dropdown-item" href="javascript:void(0);" data-language="de"><i class="flag-icon flag-icon-de mr-50"></i> German</a><a class="dropdown-item" href="javascript:void(0);" data-language="pt"><i class="flag-icon flag-icon-pt mr-50"></i> Portuguese</a></div>
                        </li> --}}
                        {{-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
                                <div class="search-input-close"><i class="bx bx-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li> --}}
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up">{{ count($notifications) }}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    {{-- <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">{{ count($notifications) }} new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div> --}}
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">{{ count($notifications) }} new Notification</span></div>
                                </li>
                                <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0);">
                                      
                                  
                                 
                                 @foreach ($notifications as $item)
                                     
                                </a><a href="{{ route('dashboard.readNotification',$item->id) }}" class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">{{ $item->data['msg'] }}</span></h6><small class="notification-text">{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                 @endforeach
                                  
                                  
                                    </a></li>
                                {{-- <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li> --}}
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name">{{ auth()->user()->name }}</span><span class="user-status text-muted"></span></div><span></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                @role('superAdmin')
                                <a class="dropdown-item" href="{{ route('dashboard.admins.editSuperAdmin') }}"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                                @endrole
                                {{-- <a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a>
                                <a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a>
                                <a class="dropdown-item" href="app-chat.html"><i class="bx bx-message mr-50"></i> Chats</a> --}}
                                <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="{{ route('dashboard.logout') }}"><i class="bx bx-power-off mr-50"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @extends('dashboard.layout.menu')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    <!-- demo chat-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-left d-inline-block">2022 &copy; Moather</span><span class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="https://www.josequal.com/" target="_blank">Josequal</a></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('main2/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('main2/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
    <script src="{{ asset('main2/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
    <script src="{{ asset('main2/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('main2/js/scripts/configs/vertical-menu-light.js') }}"></script>
    <script src="{{ asset('main2/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('main2/js/core/app.js') }}"></script>
    <script src="{{ asset('main2/js/scripts/components.js') }}"></script>
    <script src="{{ asset('main2/js/scripts/footer.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('main2/js/scripts/navs/navs.js') }}"></script>
    <!-- END: Page JS-->
    <script src="{{asset('main2/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('main2/vendors/js/extensions/dragula.min.js')}}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('main2/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
    {{-- <script src="{{ asset('main2/js/scripts/app-user-view.js') }}"></script>
    <script src="{{ asset('main2/js/scripts/app-user-view-account.js') }}"></script>
    <script src="{{ asset('main2/js/scripts/modal-edit-user.js') }}"></script>
    <script src="{{ asset('main2/js/pages-account-settings-billing') }}"></script>
    <script src="{{ asset('main2/js/pages-account-settings-security') }}"></script> --}}
    <script src="{{ asset('js/videopopup.js') }}"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('scripts')

    @include('sweetalert::alert')


</body>
<!-- END: Body-->

</html>