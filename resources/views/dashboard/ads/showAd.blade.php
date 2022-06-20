@extends('dashboard.layout.index')
@section('style')
<link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">
<link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
@endsection
@section('content')
    <div class="app-content content">

        <section id="basic-input" class="content-wrapper">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Influencers</p>
                    </div>
                    <hr class="w-100 mt-1">
                </div>
                <div class="card-body">
                    @include('dashboard.ads.include.influencers')
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Ad Details</p>
                    </div>
                    <hr class="w-100 mt-1">
                </div>

                <div class="card-body">
                    @include('dashboard.ads.include.campaigns')
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Content</p>
                    </div>
                    <hr class="w-100 mt-1">
                </div>
                <div class="card-body">
                    @include('dashboard.ads.include.content')
                </div>
            </div>

            <div id="seeContract" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Contract</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea name="content" id="contractContent" rows="10" cols="80"></textarea>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Scenario</label>
                                <textarea class="form-control" name="content" id="scenario" rows="10" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Date</label>
                                <input id="contractDate" value="" name="website_link" type="date" class="form-control"
                                    id="inputAddress2" placeholder="date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary text-center align-middle" onclick="sendContract()">
                                Send
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

           
            <div id="accept_ad_contract" class="modal accept_adcontract_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body accept_ad_contract_body">
                            <p>Please provide the ad link</p>
                            <input type="text" id="link_ad_contract_input" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="sendAdContractStatus()" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteFile" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body deleteModal">
                                <h1 class="wont">Delete</h1>
                                <p>Are you sure you want to delete This File ? After Deleteing the file you will not be able
                                    to restore it</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button onclick="deleteFile()" type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
            </div>

            <div id="unchosen_inf" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog full-modal-dialog" role="document">
                    <div class="modal-content full-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Replace Influencer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


          </div>
      </section>
  </div>
@endsection

@section('scripts')
    <script>

        $(function(){

            $('#ad-type').on('change',function(){
                $('#ad-category').html('');
                let items = $('#ad-type option[value="'+$(this).val()+'"]').attr('data-items');
                items = JSON.parse(items) || [];
                items.forEach(element => {
                    let selected = $('#ad-category').attr('data-item') == element.id ? 'selected' : '';
                    $('#ad-category').append(`<option value="${element.id}" ${selected}>${element.name.en}</option>`) 
                });
            }).change();
            $('#ad-type').attr('disabled',true);
            $('#ad-category').attr('disabled',true);
            $('#eng_number').attr('disabled',true);


            $('.open-choose-video').on('click',function(){
                $('#adVideo').trigger('click');
            });
            $('.open-choose-image').on('click',function(){
                $('#addImage').trigger('click');
            });

            $('#adVideo,#addImage').on('change',function(){
                var itemId = $(this).attr('id');
                let video = document.getElementById(itemId).files[0];
                let formData = new FormData();
                formData.append('file', video)
                let url = '{{ route('dashboard.ads.uploadVideo', ':id') }}';
                if (fileType) url = '{{ route('dashboard.ads.uploadImage', ':id') }}';
                let addIdToURL = url.replace(':id', '{{ $data->id }}');
                $.ajax({
                    url: addIdToURL,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: (res) => {
                            if (res.status == 200) {
                            if (res.data.added_video) {
                                $('#videoSection').append(`
                                    <div class="col-3 h-25 mt-2">
                                    <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                        <a href="${res.data.added_video.url}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ asset('img/icons/misc/mp4.jpg') }}" width="40" />
                                        </a>
                                    <div class="ml-2">
                                        <h6 class="mb-0">Video #${res.data.number_of_videos}</h6>
                                        <div class="about"><button onclick="deleteFileModal(${res.data.added_video.id})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                        </div>
                                    </div>
                                    </div> 
                                `);
                            } else {
                                $('#imageSection').append(`
                                    <div class="col-3 h-25 mt-2">
                                    <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                        <a href="${res.data.added_image.url}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ asset('img/icons/misc/img.png') }}" width="40" />
                                        </a>
                                    <div class="ml-2">
                                        <h6 class="mb-0">Image #${res.data.number_of_images}</h6>
                                        <div class="about"><button onclick="deleteFileModal(${res.data.added_image.id})" type="button" class="deleteButton"><span class="small">Delete</span></button></div>
                                        </div>
                                    </div>
                                    </div>
                                `);
                            }
                            Toast.fire({
                                icon: 'success',
                                title: 'File was uploaded successfully'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'server response :' + res.msg
                            });
                        }
                    },
                    error: (res) => {
                        let msg = res.responseJSON.err;
                        if (!msg) msg = 'Server Error!'

                        Toast.fire({
                            icon: 'error',
                            title: msg
                        })

                    }
                });
            });
        });


        let ad_id = '{{ $data->id }}';

        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        let choosen_inf_id = 0;
        let showAddress = false;
        var notChange = null;

        let removed_inf = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        CKEDITOR.replace('contractContent', {
            extraPlugins: 'placeholder',
            height: 220,
            removeButtons: 'PasteFromWord'
        });
        let fileType = null;
        let deletetedFileId = null;

        function getUnchosenInfulncers($this,inf_id) {
            removed_inf = inf_id;
            let url = '{{ route("dashboard.ads.getUnmatchedInfluencers",["ad_id" => $data->id,"influencer_id" => ":inf_id"]) }}';
            url = url.replace(':inf_id',inf_id);
            $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: (res) => {
                if(res.count){
                    $('#unchosen_inf .modal-body').html(res.influencers);
                    $('#unchosen_inf').modal('show');
                }else{
                    Swal.fire(
                        '',
                        'No influencers found in unmatched list',
                        'error'
                    )
                }
                $($this).attr('disabled',false).html(`<i class="bx bx-transfer"></i>`);
                console.log(res);
                },
                error: (err) => {
                    console.log(err);
                    $($this).attr('disabled',false).html(`<i class="bx bx-transfer"></i>`);
                }
            });
            
        }

        function replaceInfluncer($this,inf_id) {
            let url = "{{ route('dashboard.ads.changeMatch', [$data->id, ':removed_inf', ':chosen_inf']) }}";
            url = url.replace(':removed_inf', removed_inf);
            url = url.replace(':chosen_inf', inf_id)

            $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'GET',
                url: url,
                success: (res) => {
                    if(res.status){
                        $('.influencer-data').html(res.data);
                    }else{
                        Swal.fire(
                            '',
                            res.error,
                            'error'
                        )
                    }
                    $('#unchosen_inf').modal('hide');
                    $($this).attr('disabled',false).html(`<i class="bx bx-check"></i>`);
                },
                error: (err) => {
                    console.log(err);
                    $($this).attr('disabled',false).html(`<i class="bx bx-check"></i>`);
                }
            });

        }

        function approveInfluencersList($this) { 
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '{{ route("dashboard.ads.approveInfluencersList",["ad_id" => $data->id]) }}';
                    $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> Approve Influencers List`);
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'json',
                        success: (res) => {
                            totalInfluencers = res.totalInfluencers;
                            $('.influencer-data').html(res.data);
                            $($this).attr('disabled',false).html(`Approve Influencers List`);
                            Swal.fire(
                                'Confirmed!',
                                'Influencers have been confirmed.',
                                'success'
                            );
                            $($this).parent().remove();
                        },
                        error: (err) => {
                            console.log(err);
                            $($this).attr('disabled',false).html(`Approve Influencers List`);
                        }
                    });
                    
                }
            });
        }

        function removeInfluencer($this,inf_id) { 
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '{{ route("dashboard.ads.deleteMatchInfluencers",["ad_id" => $data->id,"influencer_id" => ":inf_id"]) }}';
                    url = url.replace(':inf_id',inf_id);
                    $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i>`);
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'json',
                        success: (res) => {
                            totalInfluencers = res.totalInfluencers;
                            $('.influencer-data').html(res.data);
                            $($this).attr('disabled',false).html(`<i class="fas fa-user-times"></i>`);
                            Swal.fire(
                                'Deleted!',
                                'Influencer has been deleted.',
                                'success'
                            )
                        },
                        error: (err) => {
                            console.log(err);
                            $($this).attr('disabled',false).html(`<i class="fas fa-user-times"></i>`);
                        }
                    });
                    
                }
            });
        }


        function seeContract(content, inf_id) {
            choosen_inf_id = inf_id;
            $('#contractContent').empty();
            let obj = CKEDITOR.instances['contractContent'];
            obj.setData(content)

            $('#seeContract').modal('toggle');
        }

        function sendContract(sendToAll = false) {
            let url = '{{ route('dashboard.ads.sendContractToInfluncer', ':id') }}';
            let addId = url.replace(':id', '{{ $data->id }}');
            $.ajax({
                url: addId,
                data: {
                    influncers_id: choosen_inf_id,
                    date: document.getElementById('contractDate').value,
                    scenario: document.getElementById('scenario').value,
                    send_to_all: sendToAll,
                },
                type: 'POST',
                success: (res) => {
                    document.getElementById('contractContent').value = '';
                    location.reload();
                    $('#seeContract').modal('toggle');
                },
                error: (err) => {
                    console.log('error: ', err);
                }
            })

        }

        function deleteFileModal(id) {
            deletetedFileId = id;
            $('#deleteFile').modal('toggle');
        }

        function deleteFile() {
            let url = '{{ route('dashboard.ads.deleteFile', ':id') }}';
            let updateUrl = url.replace(':id', deletetedFileId);
            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: {},
                success: (res) => {
                    console.log('res: ', res);
                    location.reload();
                },
                error: (err) => {
                    console.log('err: ', err);
                }
            });
        }

        function mainForm() {
            $('#mainForm').submit();
        }


        let chossen_contract_id = 0;

        function reject_data_inf(contract_id) {
            chossen_contract_id = contract_id
            $('#reject_ad_contract').modal('toggle');

        }

        function accept_data_inf(contract_id) {
            chossen_contract_id = contract_id
            $('#accept_ad_contract').modal('toggle');
        }

        function sendAdContractStatus(reject = null) {
            let rejectNote = document.getElementById('reject_ad_contract_input').value;
            let link = document.getElementById('link_ad_contract_input').value;

            if (reject && !rejectNote) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please add the rejct reason'
                })
                return;
            }

            if (!reject && !link) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please add the ad link'
                })
                return;
            }


            let url = '{{ route('dashboard.ads.changeStatus', ':contract_id') }}';
            let urlWithContractId = url.replace(':contract_id', chossen_contract_id);
            $.ajax({
                url: urlWithContractId,
                type: 'POST',
                data: {
                    status: rejectNote ? 0 : 1,
                    rejectNote,
                    link
                },
                success: (res) => {
                    window.location.reload()
                },
                error: (err) => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro updateing influncer'
                    })
                    console.log('Error changeing the status: ', err)
                },
            })
        }
    </script>
@endsection
