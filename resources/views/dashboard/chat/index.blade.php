@extends('dashboard.layout.index')
@section('content')

<div class="app-content content chat-application">
    <div class="content-area-wrapper">
        <div class="sidebar-left">
            <div class="sidebar">
                <!-- app chat sidebar start -->
                <div class="chat-sidebar card">
                    <span class="chat-sidebar-close">
                        <i class="bx bx-x"></i>
                    </span>
                    <div class="chat-sidebar-search">
                        <div class="d-flex align-items-center">
                            <div class="chat-sidebar-profile-toggle">
                                <div class="avatar">
                                    <img src="{{ Auth::user()->adminImage['url'] }}" alt="user_avatar" class="admin-avatar" height="36" width="36">
                                </div>
                            </div>
                            <fieldset class="form-group position-relative has-icon-left mx-75 mb-0">
                                <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="bx bx-search-alt text-dark"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="chat-sidebar-list-wrapper">
                        <h6 class="px-2 pt-1 pb-25 mb-0">CHATS</h6>
                        <ul class="chat-sidebar-list list-unstyled">
                            @foreach ($users as $item)
                            <li onclick="get_active_user_messages(this,'{{ $item->id }}')" class="d-flex align-items-center user-item" data-id="{{ $item->id }}" >
                                <div class="avatar m-0 mr-50">
                                    <img src="{{ $item->influncers ? $item->infulncerImage['url'] : $item->image['url'] }}" height="36" width="36" alt="sidebar user image">
                                    <span class="avatar-status-busy avatar-status"></span>
                                </div>
                                <div class="chat-sidebar-name">
                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                    <span class="text-muted">{{ $item->type }}</span>
                                </div>
                            </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- app chat sidebar ends -->
            </div>
        </div>
        <div class="content-right">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- app chat overlay -->
                    <div class="chat-overlay"></div>
                    <!-- app chat window start -->
                    <section class="chat-window-wrapper">
                        <div class="chat-start">
                            <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
                            <h4 class="d-none d-lg-block py-50 text-bold-500">Select a contact to start a chat!</h4>
                            <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1">Start Conversation!</button>
                        </div>
                        <div class="chat-area d-none">
                            <div class="chat-header">
                                <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75">
                                    <div class="d-flex align-items-center">
                                        <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                                        </div>
                                        <div class="avatar chat-profile-toggle m-0 mr-1">
                                            <img id="active_user_image" src="" alt="avatar" height="36" width="36" />
                                            <span class="avatar-status-busy"></span>
                                        </div>
                                        <h6 id="active_user_chat" class="mb-0"></h6>
                                    </div>
                                    <div class="chat-header-icons">
                                      
                                    </div>
                                </header>
                            </div>
                            <!-- chat card start -->
                            <div id="chat_body" class="card chat-wrapper shadow-none">
                                <div id="messagesContainer" class="card-body chat-container p-0">
                                    <div id="chat_messages"  class="chat-content p-2"></div>
                                </div>
                                <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">
                                    <form class="d-flex align-items-center" onsubmit="chatMessagesSend();" action="javascript:void(0);">
                                        <i class="bx bx-face cursor-pointer"></i>
                                        <i class="bx bx-paperclip ml-1 cursor-pointer"></i>
                                        <input id="message" type="text" class="form-control chat-message-send mx-1" placeholder="Type your message here...">
                                        <button  type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                                            <span class="d-none d-lg-block ml-1">Send</span></button>
                                    </form>
                                </div>
                            </div>
                            <!-- chat card ends -->
                        </div>
                    </section>
                    <!-- app chat window ends -->
                    <!-- app chat profile right sidebar start -->
                    <section class="chat-profile">
                        <header class="chat-profile-header text-center border-bottom">
                            <span class="chat-profile-close">
                                <i class="bx bx-x"></i>
                            </span>
                            <div class="my-2">
                                <div class="avatar">
                                    <img id="active_user_image_profile"   src="" alt="chat avatar" height="100" width="100">
                                </div>
                                <h5 id="active_user_name" class="app-chat-user-name mb-0"></h5>
                                <span id="active_user_role" ></span>
                            </div>
                        </header>
                        <div class="chat-profile-content p-2">
                            <h6  class="mt-1">ABOUT</h6>
                            <p id="active_user_bio"></p>
                            <h6 class="mt-2">PERSONAL INFORMATION</h6>
                            <ul class="list-unstyled">
                                <li id="active_user_email" class="mb-25"></li>
                                <li id="active_user_phone"></li>
                            </ul>
                        </div>
                    </section>
                    <!-- app chat profile right sidebar ends -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
<script src="{{asset('main2/js/scripts/pages/app-chat.js')}}"></script>
<script>
    let token = '{{csrf_token()}}';
    var socket = io.connect('{{env("SOCKET_URL")}}',{secure: false,transports: ['websocket'],upgrade: false,query: {token: token}});
        
    socket.on('connect', function (err) {
        console.log('connected');
    });

    socket.on('disconnect',function(res){
        console.log('disconnect');
    });

    socket.on('error', function (err) {
        console.log('error',err);
    });

    // socket.on('test', function (data) {
    //         console.log('after connection: ',data);
    //         data.image = boxItem.find('img').attr('src');
    //         setMessageData(data,true);
    //     });

    socket.on('get.online.users', (users) => {
        console.log(users);
        for (var key in users) {
            $('.user-item[data-id="'+users[key]+'"]').find('.avatar-status').removeClass('avatar-status-busy').addClass('avatar-status-online');
        }
    });

    socket.on('user.online', (userId) => {
        console.log(userId);
        $('.user-item[data-id="'+userId+'"]').find('.avatar-status').removeClass('avatar-status-busy').addClass('avatar-status-online');
    });


    socket.on('user.offline', (userId) => {
        console.log(userId);
        $('.user-item[data-id="'+userId+'"]').find('.avatar-status').removeClass('avatar-status-online').addClass('avatar-status-busy');
    });


    let current_user_id = '{{ auth()->user()->id }}';
    let senToUser = 0;
    let oldUserId = 0;
    let channel = '';
    function get_active_user_messages($this,user_id)
    {
        let boxItem = $($this);

        boxItem.addClass('active').siblings().removeClass('active');
        senToUser = user_id;
        let url = '{{ route("dashboard.chat.get_messages","user_id:") }}';
        let add_id = url.replace('user_id:',user_id);
        
        $.ajax({
            url:add_id,
            type:'get',
            success :(res)=>{
                let user_info = res.data.user
                if(res.status == 200)
                {
                    $("#active_user_image_profile,#active_user_image").attr("src",user_info.image);
                    $("#active_user_name,#active_user_chat").text(user_info.name);
                    $("#active_user_role").text(user_info.type);
                    $("#active_user_bio").text(user_info.email);
                    $("#active_user_phone").text(user_info.phone);
                    $("#chat_messages").empty();

                    

                    for(let i =0; i < res.data.messages.length; i++) {
                        let element = res.data.messages[i]
                        if(element.sender_id == current_user_id){
                            let senderDiv = `<div class="chat">
                                                <div class="chat-avatar">
                                                    <a class="avatar m-0">
                                                    <img src="${user_info.image}" alt="avatar" height="36" width="36" />
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>${element.text}</p>
                                                        <span class="chat-time">${element.time}</span>
                                                </div>
                                                </div>
                                            </div>`;
                           $("#chat_messages").append(senderDiv);
                        }else{
                            let reciverDiv = `<div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <a class="avatar m-0">
                                                        <img src="${user_info.image}" alt="avatar" height="36" width="36" />
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-message">
                                                        <p>${element.text}</p>
                                                        <span class="chat-time">${element.time}</span>
                                                    </div>
                                                
                                                </div>
                                            </div>`;
                           $("#chat_messages").append(reciverDiv);
                        }
                    }
                    // new PerfectScrollbar(".chat-container");
                    var objDiv = document.getElementById("chat_messages");
                    chatContainer.find('.chat-content').animate({ scrollTop: objDiv.scrollHeight }, 400);
                    
                }else{
                    alert('some thing wrong');
                }
            },
            error:(err)=>{
                console.log(err)
            }
        });

        socket.removeAllListeners("message.user-"+oldUserId);
        oldUserId = user_id;
        channel = 'support.user-' + senToUser;
        //console.log('c: ',channel)
        socket.on(channel, function (data) {
            console.log('after connection: ',data);
            data.image = boxItem.find('img').attr('src');
            setMessageData(data,data.sender_id != 1);
        });
        
        $('#chat_body').show();
    }

    // Add message to chat
    function chatMessagesSend(source) {
        let chatMessageSend = $(".chat-message-send");
        var message = chatMessageSend.val();
        var d = new Date();
        let time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

        if (message != "") {
            let adminAvatar = $('.admin-avatar').attr('src');
            
            chatMessageSend.val("");
        }

        socket.emit(channel, {
            message: message,
            sender_id: 1,
            receiver_id: senToUser,
        });
    }

    function setMessageData(data,left = false){

        let html = `<div class="chat ${ left ? 'chat-left' : '' }">
                            <div class="chat-avatar">
                                <a class="avatar m-0">
                                <img src="${data.image}" alt="avatar" height="36" width="36" />
                                </a>
                            </div>
                            <div class="chat-body">
                            <div class="chat-message">
                                <p>${data.message}</p>
                                    <span class="chat-time">${data.time}</span>
                            </div>
                            </div>
                        </div>`;
        $("#chat_messages").append(html);
        chatContainer.animate({ scrollTop: chatContainer[0].scrollHeight }, 400);
    }
</script>
@endsection