<script>
    let ad_id = '{{ $data->id }}';
    let choosen_inf_id = 0;
    let removed_inf = 0;
    let fileType = null;
    let loadButton = null;
    let deletetedFileId = null;
    let chossen_contract_id = 0;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
    });
    
    $(function(){

        CKEDITOR.replace('contract-text', {
            extraPlugins: 'justify,placeholder,colorbutton,font,indent,indentblock,indentlist',
            height: 600,
            contentsLangDirection: 'rtl',
            removeButtons: 'PasteFromWord',
            allowedContent: true
        });

        CKEDITOR.replace('contract-influencer-text', {
            extraPlugins: 'justify,placeholder,colorbutton,font,indent,indentblock,indentlist',
            height: 600,
            contentsLangDirection: 'rtl',
            removeButtons: 'PasteFromWord',
            allowedContent: true
        });

        $(document).on('change','#ad-type',function(){
            $('#ad-category').html('');
            let items = $('#ad-type option[value="'+$(this).val()+'"]').attr('data-items');
            items = JSON.parse(items) || [];
            items.forEach(element => {
                let selected = $('#ad-category').attr('data-item') == element.id ? 'selected' : '';
                $('#ad-category').append(`<option value="${element.id}" ${selected}>${element.name.ar}</option>`) 
            });
        });
        $('#ad-type').change();

        $(document).on('click','.open-choose-video',function(){
            $('#adVideo').trigger('click');
            loadButton = $(this);
            fileType = 'video';
        });
        $(document).on('click','.open-choose-image',function(){
            $('#addImage').trigger('click');
            loadButton = $(this);
            fileType = 'image';
        });

        $(document).on('input','#adVideo,#addImage',function(){
            var itemId = $(this).attr('id');
            loadButton.attr('disabled',true);
            let video = document.getElementById(itemId).files[0];
            let formData = new FormData();
            formData.append('file', video);
            let url = '';
            if (fileType == 'video'){
                url = '{{ route('dashboard.ads.uploadVideo', ':id') }}';
            }else{
                url = '{{ route('dashboard.ads.uploadImage', ':id') }}';
            } 
            
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
                                <div class="col-md-4 col-6 mt-2" data-id="${res.data.added_video.id}">
                                    <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                        <a href="${res.data.added_video.url}" target="_blank" rel="noopener noreferrer">
                                            <img src="${res.data.added_video.thumbnail}" width="40" />
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
                                <div class="col-md-4 col-6 mt-2" data-id="${res.data.added_image.id}">
                                <div class="pt-2 pb-2 pl-1 video-item d-flex align-items-center">
                                    <a href="${res.data.added_image.url}" target="_blank" rel="noopener noreferrer">
                                        <img src="${res.data.added_image.url}" width="40" />
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
                    loadButton.attr('disabled',false);
                },
                error: (res) => {
                    let msg = res.responseJSON.err;
                    if (!msg) msg = 'Server Error!'

                    Toast.fire({
                        icon: 'error',
                        title: msg
                    });
                    loadButton.attr('disabled',false);

                }
            });
        });
    });

    //Open non choosen influencers
    function getUnchosenInfulncers($this,inf_id) {
        removed_inf = inf_id;
        let url = '{{ route("dashboard.ads.getUnmatchedInfluencers",["ad_id" => $data->id,"influencer_id" => ":inf_id"]) }}';
        url = url.replace(':inf_id',inf_id);
        if(inf_id > 0){
            $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        }else{
            $($this).attr('disabled',true).html($($this).text() + ` <i class="fa fa-spinner fa-spin"></i>`);
        }
        
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

                if(inf_id > 0){
                    $($this).attr('disabled',false).html(`<i class="bx bx-transfer"></i>`);
                }else{
                    $($this).attr('disabled',false).html($($this).text());
                }
                
            },
            error: (err) => {
                console.log(err);
                $($this).attr('disabled',false).html(`<i class="bx bx-transfer"></i>`);
            }
        });
        
    }

    //Change influencer from choosen
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
                Swal.fire(
                    'Error!',
                    err.responseJSON.message,
                    'error'
                );
                $($this).attr('disabled',false).html(`<i class="bx bx-check"></i>`);
            }
        });

    }

    //Add influencer from choosen
    function addInfluncer($this,inf_id) {
        let url = "{{ route('dashboard.ads.addInfluencerMatch', [$data->id, ':chosen_inf']) }}";
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

    //Admin approve influencers list
    function approveInfluencersList($this) { 
        Swal.fire({
            title: 'Are you sure?',
            text: "The campaign budget will change to the sum of chosen influencers prices. You won't be able to revert this!",
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
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    success: (res) => {
                        if(res.status){
                            Swal.fire(
                                'Confirmed!',
                                'Influencers have been confirmed.',
                                'success'
                            );
                            $($this).parent().after(`<div class="d-flex justify-content-center">
                                                <a class="btn btn-secondary mr-1" href="{{ route('dashboard.ads.contract-pdf',$data->id) }}" target="_blank" >Print</a>
                                                <button  type="button" onclick="viewContract(this)" class="btn btn-secondary">View Contract</button>
                                            </div> `);
                            $($this).parent().remove();

                        }else{
                            Swal.fire(
                                'Error!',
                                res.msg,
                                'error'
                            );
                        }
                        $($this).attr('disabled',false).html(`Approve Influencers List`);
                    },
                    error: (err) => {
                        console.log(err);
                        $($this).attr('disabled',false).html(`Approve Influencers List`);
                    }
                });
                
            }
        });
    }

    //Open contract modal
    function viewContract($this){
        let url = '{{ route("dashboard.ads.show_contract",["id" => $data->id]) }}';
        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: (res) => {
                if(res.status){
                    CKEDITOR.instances['contract-text'].setData(res.contract);
                    $('#campaign-modal').modal('show');
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                console.log(err);
                $($this).attr('disabled',false).html($($this).text());
            }
        });
    }

    //Update Contract for campaign
    function updateContract($this){
        let url = '{{ route("dashboard.ads.updateContract",["ad_id" => $data->id]) }}';
        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            type: 'POST',
            url: url,
            data: {'content': CKEDITOR.instances['contract-text'].getData()},
            dataType: 'json',
            success: (res) => {
                if(res.status){
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    );
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                console.log(err);
                $($this).attr('disabled',false).html($($this).text());
            }
        });
    }

    //Remove influencer from choosen list
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

    //Open Modal for influencer date and scenario
    function openInfluencerDataModal($this,inf_id) {
        choosen_inf_id = inf_id;
        $('#scenario,#contractDate').val('');
        if($('tr[data-id="'+choosen_inf_id+'"] .sinario').hasClass('has-content')){
            $('#scenario').val($('tr[data-id="'+choosen_inf_id+'"] .sinario').text());
        }
        if($('tr[data-id="'+choosen_inf_id+'"] .date').hasClass('has-content')){
            $('#contractDate').val($('tr[data-id="'+choosen_inf_id+'"] .date').attr('data-date'));
        }
        $('#influencer-data').modal('toggle');
    }

    //Save influencer Date and scenario
    function saveInfluencerData($this) {
        let url = '{{ route('dashboard.ads.sendContractToInfluncer', ':id') }}';
        let addId = url.replace(':id', '{{ $data->id }}');

        if($('#scenario').val().trim() == '' || $('#contractDate').val().trim() == ''){
            Swal.fire(
                'Error!',
                'Please fill all fields',
                'error'
            );
            return false;
        }

        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            url: addId,
            data: {
                influncers_id: choosen_inf_id,
                scenario: document.getElementById('scenario').value,
                date: document.getElementById('contractDate').value
            },
            type: 'POST',
            success: (res) => {
                if(res.status){
                    Swal.fire(
                        'Saved!',
                        'Influencer data was saved successfully',
                        'success'
                    );
                    let dateArray = document.getElementById('contractDate').value.split('-');
                    let year = dateArray[0] || '';
                    let month = dateArray[1] || '';
                    let day = dateArray[2] || '';
                    let date = `${day}/${month}/${year}`;

                    $('tr[data-id="'+choosen_inf_id+'"] .sinario').text(document.getElementById('scenario').value).addClass('has-content');
                    $('tr[data-id="'+choosen_inf_id+'"] .date').text(date).addClass('has-content').attr('data-date',document.getElementById('contractDate').value);
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                
                $('#influencer-data').modal('hide');
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                Swal.fire(
                    'Error!',
                    err.responseJSON.message,
                    'error'
                );
                console.log('error: ', err);
                $($this).attr('disabled',false).html($($this).text());
            }
        })

    }

    //Open Delete File Modal
    function deleteFileModal(id) {

        Swal.fire({
            title: 'Are you sure you want delete this file?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('dashboard.ads.deleteFile', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {},
                    success: (res) => {
                        console.log('res: ', res);
                        $('[data-id="'+ id +'"]').remove();
                    },
                    error: (err) => {
                        console.log('err: ', err);
                    }
                });
                
            }
        });
    }

    //Open Contract Pdf
    function printContract($this){
        let url = "{{ route('dashboard.ads.printContract',$data->id) }}";
        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            url: url,
            type: 'get',
            success: (res) => {
                if(res.status){
                    window.open(res.url, "_blank");
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                Swal.fire(
                    'Error!',
                    err.responseJSON.message,
                    'error'
                );
                console.log('error: ', err);
                $($this).attr('disabled',false).html($($this).text());
            }
        });
    }

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

    function openModal($this,modalId){
        $('#' + modalId).modal('show');
        return false;
    }

    //Get Influencer Contract
    function getInfluencerContract($this,contract_id){
        let url = '{{ route("dashboard.ads.show_influencer_contract",["contract_id" => ":contract_id"]) }}';
        url = url.replace(':contract_id',contract_id);
        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: (res) => {
                if(res.status){
                    CKEDITOR.instances['contract-influencer-text'].setData(res.contract);
                    $('#contract-influencer-id').val(contract_id);
                    $('#influencer-contract-modal').modal('show');
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                console.log(err);
                $($this).attr('disabled',false).html($($this).text());
            }
        });
    }

    //Update Contract for influencer
    function updateInfluencerContract($this){
        let contract_id = $('#contract-influencer-id').val();
        let url = '{{ route("dashboard.ads.updateInfluencerContract",["contract_id" => ":contract_id"]) }}';
        url = url.replace(':contract_id',contract_id);
        $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
        $.ajax({
            type: 'POST',
            url: url,
            data: {'content': CKEDITOR.instances['contract-influencer-text'].getData()},
            dataType: 'json',
            success: (res) => {
                if(res.status){
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    );
                }else{
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
                $($this).attr('disabled',false).html($($this).text());
            },
            error: (err) => {
                console.log(err);
                $($this).attr('disabled',false).html($($this).text());
            }
        });
    }

    //Open Contract Pdf
    function printInfluencerContract(contract_id = false){
        if(!contract_id){
            contract_id = $('#contract-influencer-id').val();
        }
        
        let url = "{{ route('dashboard.ads.printInfluencerContract',':contract_id') }}";
        url = url.replace(':contract_id',contract_id);
        window.open(url, "_blank");
    }

    //Resend Contract for influencer
    function resendContract($this,contract_id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Notification will send to influencer to infform him that you are resend the contract!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve!'
        }).then((result) => {
            if(result.isConfirmed){
                let url = '{{ route("dashboard.ads.resendContract",["contract_id" => ":contract_id"]) }}';
                url = url.replace(':contract_id',contract_id);
                $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    success: (res) => {
                        if(res.status){
                            Swal.fire(
                                'Success!',
                                res.message,
                                'success'
                            );
                            window.location.reload();
                        }else{
                            Swal.fire(
                                'Error!',
                                res.message,
                                'error'
                            );
                        }
                        $($this).attr('disabled',false).html($($this).text());
                    },
                    error: (err) => {
                        console.log(err);
                        $($this).attr('disabled',false).html($($this).text());
                    }
                });
            }
        });
    }

</script>