@extends('dashboard.layout.index')
@section('content')

<style>
    .user-item {
    background: none;
    border: none;
}
</style>

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
                                    <img onerror="this.onerror=null;this.src='https://timesaver247.com/wp-content/uploads/2020/10/default-user-image.png';" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" height="36" width="36">
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
                        <ul class="chat-sidebar-list">
                                @foreach ($users as $item)
                                <li>
                                <button onclick="get_active_user_messages('{{ $item->id }}')" class="d-flex align-items-center user-item">
                                    <div class="avatar m-0 mr-50"><img onerror="this.onerror=null;this.src='https://timesaver247.com/wp-content/uploads/2020/10/default-user-image.png';"
                                        src="{{ $item->image }}" height="36" width="36" alt="sidebar user image">
                                        {{-- <span class="avatar-status-busy"></span> --}}
                                    </div>
                                    <div class="chat-sidebar-name">
                                        <h6 class="mb-0">{{ $item->name }}</h6><span class="text-muted">{{ $item->type }}</span>
                                    </div>
                                </button>
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
                                            <img id="active_user_image" src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="avatar" height="36" width="36" />
                                            <span class="avatar-status-busy"></span>
                                        </div>
                                        <h6 id="active_user_chat" class="mb-0">user name</h6>
                                    </div>
                                    <div class="chat-header-icons">
                                      
                                    </div>
                                </header>
                            </div>
                            <!-- chat card start -->
                            <div id="chat_body" class="card chat-wrapper shadow-none">
                                <div id="messagesContainer" class="card-body chat-container">
                                    <div id="chat_messages"  class="chat-content">
                                        <div class="chat">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>How can we help? We're here for you! 😄</p>
                                                    <span class="chat-time">7:45 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>Hey John, I am looking for the best admin template.</p>
                                                    <p>Could you please help me to find it out? 🤔</p>
                                                    <span class="chat-time">7:50 AM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>It should be Bootstrap 4 🤩 compatible.</p>
                                                    <span class="chat-time">7:58 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="badge badge-pill badge-light-secondary my-1">Yesterday</div> --}}
                                        <div class="chat">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>Absolutely!</p>
                                                    <span class="chat-time">8:00 AM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>Stack admin is the responsive bootstrap 4 admin template.</p>
                                                    <span class="chat-time">8:01 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>Looks clean and fresh UI. 😃</p>
                                                    <span class="chat-time">10:12 AM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>It's perfect for my next project.</p>
                                                    <span class="chat-time">10:15 AM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>How can I purchase 🤑 it?</p>
                                                    <span class="chat-time">10:18 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>Thanks 🤝 , from ThemeForest.</p>
                                                    <span class="chat-time">10:20 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>I will purchase it for sure. 👍</p>
                                                    <span class="chat-time">3:32 PM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>Thanks.</p>
                                                    <span class="chat-time">3:33 PM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat">
                                            <div class="chat-avatar">
                                                <a class="avatar m-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>Great, Feel free to get in touch on</p>
                                                    <span class="chat-time">3:34 AM</span>
                                                </div>
                                                <div class="chat-message">
                                                    <p>https://pixinvent.ticksy.com/</p>
                                                    <span class="chat-time">3:35 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <img onerror="this.onerror=null;this.src='https://timesaver247.com/wp-content/uploads/2020/10/default-user-image.png';" id="active_user_image_profile"   src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="chat avatar" height="100" width="100">
                                </div>
                                <h5 id="active_user_name" class="app-chat-user-name mb-0">Elizabeth Elliott</h5>
                                <span id="active_user_role" >Devloper</span>
                            </div>
                        </header>
                        <div class="chat-profile-content p-2">
                            <h6  class="mt-1">ABOUT</h6>
                            <p id="active_user_bio">It is a long established fact that a reader will be distracted by the readable content.</p>
                            <h6 class="mt-2">PERSONAL INFORMATION</h6>
                            <ul class="list-unstyled">
                                <li id="active_user_email" class="mb-25">email@gmail.com</li>
                                <li id="active_user_phone">+1(789) 950-7654</li>
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
    var socket = io.connect('ws://192.168.1.143:3000',{secure: false,transports: ['websocket'],upgrade: false,query: {token: 'xxx'}});
        
    socket.on('connect', function (err) {
        console.log('connected');
       // io.disconnect();
    });
    socket.on('disconnect',function(res){
    })

    socket.on('message.user-5', function (data) {
        console.log('after connection: ',data)
        if(data.receiver_id == 5){
            var html = `<div class="chat-message"><p>${data.message}</p><div class="chat-time">${data.date}</div></div>`;
            $(".chat-wrapper .chat:last-child .chat-body").append(html);
        }
    });

    socket.on('error', function (err) {
        console.log('error');
        console.log(err);
    });

    let current_user_id = '{{ auth()->user()->id }}';
    let senToUser = 0;
    let oldUserId = 0;

    function get_active_user_messages(user_id)
    {
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
                    $("#active_user_name").empty();
                    $("#active_user_role").empty();
                    $("#active_user_bio").empty();
                    $("#active_user_phone").empty();
                    $("#active_user_image_profile").attr("src",user_info.image);

                    // $("#active_user_image").append(user_info.image);
                    $("#active_user_name").append(user_info.name);
                    $("#active_user_role").append(user_info.type);
                    $("#active_user_bio").append(user_info.email);
                    $("#active_user_phone").append(user_info.phone);
                    $("#chat_messages").empty();

                    for(let i =0; i < res.data.messages.length; i++) {
                        let element = res.data.messages[i]
                        if(element.sender_id == current_user_id){
                        //     let senderDiv = `<div class="chat">
                        //                         <div class="chat-avatar">
                        //                             <a class="avatar m-0">
                        //                             <img src="${user_info.image}" alt="avatar" height="36" width="36" />
                        //                             </a>
                        //                         </div>
                        //                         <div class="chat-body">
                        //                         <div class="chat-message">
                        //                             <p>${element.text}</p>
                        //                                 <span class="chat-time">${element.time}</span>
                        //                         </div>
                        //                         </div>
                        //                     </div>`;
                        //    $("#chat_messages").append(senderDiv);
                        }else{
                            let reciverDiv = `<div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <a class="avatar m-0">
                                                        <img src="${element.image}" alt="avatar" height="36" width="36" />
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
                }else{
                    alert('some thing wrong');
                }
            },
            error:(err)=>{
                console.log(err)
            }
        });

        //socket.removeListener('message.user-'+oldUserId);
        

        oldUserId = user_id;

        $('#chat_body').show();
    }

    function send_message()
    {
        
    }

    // Add message to chat
    function chatMessagesSend(source) {
        let chatMessageSend = $(".chat-message-send");
        var message = chatMessageSend.val();
        var d = new Date();
        let time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

        if (message != "") {
            var html = `<div class="chat-message"><p>${message}</p><div class="chat-time">${time}</div></div>`;
            $(".chat-wrapper .chat:last-child .chat-body").append(html);
            chatMessageSend.val("");
            chatContainer.scrollTop($(".chat-container > .chat-content").height());
        }


        $.ajax({
            url:'{{ route("dashboard.chat.send") }}',
            type:'post',
            data:{ 
                _token:'{{csrf_token()}}',
                receiver_id:senToUser,
                messages:message
            },
            success:(res)=>{},
            error:(res)=>{}

        })
    }

</script>
@endsection