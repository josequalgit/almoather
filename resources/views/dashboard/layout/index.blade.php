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
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/pages/app-chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/videopopup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/core/menu/menu-types/vertical-menu.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky pace-done {{ isset($_COOKIE['collapsed']) && $_COOKIE['collapsed'] ? 'menu-collapsed' : 'menu-expanded'}}  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right justify-content-center align-items-center">
                    
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span id="notification_counter1" class="badge badge-pill badge-danger badge-up">{{ count($notifications) }}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span id="notification_counter2" class="notification-title">{{ count($notifications) }} new Notification</span></div>
                                </li>
                                <li id="notification_list" class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0);">
                                      
                                  
                                 
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
                            </ul>
                        </li>
                        
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none m-0">
                                    <div class="avatar avatar-lg">
                                        <img src="https://pixinvent.com/demo/frest-bootstrap-laravel-admin-dashboard-template/demo/assets/img/avatars/1.png" alt="" class="rounded-circle">
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                @role('superAdmin')
                                <a class="dropdown-item" href="{{ route('dashboard.admins.editSuperAdmin') }}"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                                @endrole
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

    <button class="bottom-right">
        @if(\Request::route()->getName() != 'dashboard.chat.index' && $count_unread_messages != 0)
            <span id="message_counter" class="badge badge-pill badge-danger badge-up">{{ $count_unread_messages }}</span>
        @endif
        <a href="{{ route('dashboard.chat.index') }}"><i class="menu-icon tf-icons bx bx-chat"></i></a> 
    </button>

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
    <script src="{{ asset('js/videopopup.js') }}"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@php
$role = Auth::user()->roles[0]->name;
@endphp


<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>

@yield('scripts')

@include('sweetalert::alert')

<script>
const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 7000,
            timerProgressBar: true,
           
        })
    var socket = io.connect('{{env("SOCKET_URL")}}',{transports: ['websocket'],upgrade: false});
    socket.on('connect', function (err) {
        console.log('connected');
    });

    socket.on('disconnect',function(res){
        console.log('disconnect');
    });

    socket.on('error', function (err) {
        console.log('error',err);
    });

    @if ($role == 'superAdmin' || $role == 'Contracts Manager')

        @if($role == 'superAdmin')
        socket.on('super_admin_notification', (data) => {
            console.log('super admin notification',data);
            incress_notification(data)

        });
        socket.on('contract_manager_notification', (data) => {
            console.log('contract manager notification');
            incress_notification(data)

        });
        socket.on('supportMessages',(data)=>{
            console.log('support message: ',data);
            $('#message_counter').empty();
            $('#message_counter').append(data);
        })
        @else
        socket.on('contract_manager_notification', (data) => {
            console.log('contract manager notification');
            incress_notification(data)

        });



        @endif


        function incress_notification(data)
        {
            data = JSON.parse(data);
            
            /**  inccress the notification counter **/
        let notification_number = Number('{{auth()->user()->unreadNotifications()->count()}}')+1;
        console.log(notification_number)
        $('#notification_counter1').empty();
        $('#notification_counter2').empty();
        $('#notification_counter1').append(notification_number);
        $('#notification_counter2').append(`${notification_number} new Notification`);
            let route = "{{ route('dashboard.readNotification','id:') }}";
            let replaceId = route.replace('id:',data.not_id);
            
            /** prepend the notification item **/
            let div = `</a><a href="${replaceId}" class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                    <div class="media d-flex align-items-center">
                            <div class="media-left pr-0">
                            <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                            <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                    </div>
                </div>
                <div class="media-body">
                <h6 class="media-heading"><span class="text-bold-500">
                    ${data.message}</span></h6><small class="notification-text">${data.date}</small>
                </div>
            </div>`

         $('#notification_list').prepend(div);
            Toast.fire({
                icon: 'info',
                title: 'New Notification',
                text: data.message,
            })
        }
    @endif
</script>


</body>
<!-- END: Body-->

</html>