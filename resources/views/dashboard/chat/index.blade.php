@extends('dashboard.layout.index')
@section('content')

<div class="app-content content chat-application">
    <section id="basic-input " class="content-wrapper content-area-wrapper d-flex">
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
                                        <i class="uploadFileTrigger bx bx-paperclip ml-1 cursor-pointer"></i>
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
                    <div id="uploadFileModal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            
                            <div class="modal-body text-center">
                                <i  class="uploadIcon menu-icon tf-icons bx bx-upload"></i>
                                <h4>
                                    Upload File
                                </h4>
                              <p>Note: When click Uplaod File it will send the file directly</p>
                              <div class="mt-3 mb-3">
                                  <form id="fileForm" enctype="multipart/form-data" method="post">
                                    @csrf
                                      <input  name="chatFile" id="chatFile" onchange="readURL(this);" class="form-control pb-2" type="file" />
                                  </form>
                            </div>
                            <img id="fileChat" src="http://placehold.it/180" alt="Image" />
                            <div class="modal-footer">
                              <button onclick="sendFile()" type="button" class="btn btn-info">Send</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')

<script src="{{asset('main2/js/scripts/pages/app-chat.js')}}"></script>
<script>
    let token = '{{csrf_token()}}';
    let fileIcon = '{{ asset("img/icons/misc/downloadFile2.png") }}'

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
        let adminAvatar = $('.admin-avatar').attr('src');
        
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
                            let senderDiv = null
                            console.log(element)
                            if(element.contentType == 'file')
                            {
                                senderDiv  = `<div class="chat">
                                                <div class="chat-avatar">
                                                    <a class="avatar m-0">
                                                    <img class='downloadFilesMessages' src="${adminAvatar}" alt="avatar" height="36" width="36" />
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                <div class="chat-message">
                                                    <a href="${element.text}" download>
                                                        <img class='downloadFilesMessages' src='${fileIcon}' />
                                                    </a>
                                                </div>
                                                </div>
                                            </div>`;
                            }
                            else
                            {
                                senderDiv = `<div class="chat">
                                                <div class="chat-avatar">
                                                    <a class="avatar m-0">
                                                    <img src="${adminAvatar}" alt="avatar" height="36" width="36" />
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                <div class="chat-message">
                                                    <p>${element.text}</p>
                                                        <span class="chat-time">${element.time}</span>
                                                </div>
                                                </div>
                                            </div>`;
                            }
 
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
        console.log('sent user id: ',senToUser)

        channel = 'support.user-' + senToUser;
        //console.log('c: ',channel)
        socket.on(channel, function (data) {
            console.log('after connection: ',data);
         //   data.image = data.sender_id == 1 ? adminAvatar : user_info.image;
            data.image = data.sender_id == 1 ? adminAvatar : null;
            setMessageData(data,data.sender_id != 1);
        });
        
        $('#chat_body').show();
    }
    // Add message to chat
    function chatMessagesSend(source) {
        console.log('sourse: ',source)
        let chatMessageSend = $(".chat-message-send");
        var message = chatMessageSend.val();
       
        var d = new Date();
        let time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
        if (message != ""||source != null) {
            console.log('channel: ',channel)
            chatMessageSend.val("");
            var objDiv = document.getElementById("chat_messages");
            chatContainer.find('.chat-content').animate({ scrollTop: objDiv.scrollHeight }, 400);
            console.log("source: ",source);
            socket.emit(channel, {
                message: source?source:message,
                sender_id: 1,
                receiver_id: senToUser,
                time: time,
                contentType:source == undefined?'text':'file'
            });
        }
    }

    function setMessageData(data,left = false){
        console.log('data: ',data)
        let message = null;
        if(data.contentType == "text")
        {
            message = `<div class="chat ${ left ? 'chat-left' : '' }">
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
        }
        else
        {
           
            message = `<div class="chat">
                                                    <div class="chat-avatar">
                                                        <a class="avatar m-0">
                                                        <img src="${data.image}" alt="avatar" height="36" width="36" />
                                                        </a>
                                                    </div>
                                                    <div class="chat-body">
                                                    <div class="chat-message">
                                                        
                                                        <a href="${data.message}" download>
                                                        <img class='downloadFilesMessages' src='${fileIcon}' />
                                                    </a>
                                                    </div>
                                                    </div>
                                                </div>`;

        }



        $("#chat_messages").append(message);
        chatContainer.animate({ scrollTop: chatContainer[0].scrollHeight }, 400);
    }

    $('.uploadFileTrigger').click(()=>{
        openUploadFileModal();
    })

    function openUploadFileModal()
    {
        return $('#uploadFileModal').modal('toggle');
    }
//    $('#uploadFileModal').modal('toggle')
    var fileTypes = ['jpg', 'jpeg', 'png'];
    var videoTypes = ['mp4', 'avi', 'wmv'];

    function readURL(input) {

            if (input.files && input.files[0]) {
                let reader = new FileReader();
                let extension = input.files[0].name.split('.').pop().toLowerCase();  
              

                $('#fileChat').show();

                reader.onload = function (e) {
                    console.log('file info: ',e)
                    let  isImage = fileTypes.indexOf(extension) > -1;
                    let  isVideo = videoTypes.indexOf(extension) > -1;
                    if(!isImage)
                    {
                        if(isVideo)
                        {
                            $('#fileChat')
                         .attr('src', 'https://cdn-icons-png.flaticon.com/512/187/187326.png');
                        return;
                        }

                        $('#fileChat')
                        .attr('src', 'https://media.istockphoto.com/vectors/file-folder-in-flat-on-white-background-vector-id1175215972?k=20&m=1175215972&s=612x612&w=0&h=feHYQZBtaj92l-rpFivkPFAHupJz3vEOWqkZ6DXPDNw=');
                        return;
                    }
                    $('#fileChat')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
    }

    function sendFile()
    {
        let url = '{{ route("dashboard.chat.uploadFiles") }}';
        var files = $('#chatFile');
        console.log('files: ',files[0])
        let formData = new FormData(document.getElementById("fileForm"));
      //  formData.append("chatFile", files[0] );
            
            $.ajax({
            type: "POST",
            url: url,
            data: formData,
          
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log('success: ',data)
                chatMessagesSend(data);
                $('#uploadFileModal').modal('toggle');
              //  document.getElementById('fileChat').src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Octicons-cloud-upload.svg/1200px-Octicons-cloud-upload.svg.png';
                document.getElementById('chatFile').value = '';

            },
            error: function (error) {
                console.log('error: ',error)

            },
        })
    }
       

</script>
@endsection