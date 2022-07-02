  @extends('dashboard.layout.index')
  @section('style')
  <link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">
  <link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
  @endsection
  @section('content')
      <div class="app-content content pending-campaign">

          <section id="basic-input" class="content-wrapper">

            <div class="card">
                <div class="card-header pb-0">
                    <div class="card-title">
                        <p class="mb-0">Ad Details</p>
                    </div>
                    <hr class="w-100 mt-1">
                </div>

                <div class="card-body">
                    @if($data->status == 'rejected')
                    <div class="form-group">
                        <label for="reject-note">Reject Note</label>
                        <textarea name="reject-note-update" id="reject-note" class="form-control" rows="5">{{$data->reject_note}}</textarea>
                        <div class="text-right mt-1">
                            <button class="btn btn-danger btn-sm" id="update-reject-note" onClick="updateRejectNote(this)">Update Reject Note</button>
                        </div>
                        
                    </div>
                    @endif
                    <form id="ad_details_from" action="/" class="campaign-form">
                        <div class="row">
                            <div class="col" id="wizard-basic">
                                @include('dashboard.ads.include.campaigns')
                                @include('dashboard.ads.include.content')
                                <h3 class="f-16 ad-title">Influencers</h3>
                                <section>
                                    <div class="add-section">
                                        <div class="blocks-table d-block influencer-data">
                                            <div class="loader-wrapper">
                                                <div class="spinner-border spinner-info" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


             
            @include('dashboard.ads.include.modal')


        </section>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('main2/js/jquery.steps.min.js') }}" type="text/javascript"></script>
    @include('dashboard.ads.include.javascript')
    <script>
       
        let totalInfluencers = 0;
        $(function(){
            $("#wizard-basic").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                enablePagination: true,
                enableAllSteps: false,
                startIndex: 0,
                labels: {
                    current: "current step:",
                    pagination: "Pagination",
                    finish: "Approve",
                    next: "Next",
                    previous: "Previous",
                    loading: "Loading ..."
                },
                onInit: function() {
                    $('.actions ul').prepend(`<li class='list-dicration' aria-disabled="false"><button type='button' onclick='sendStatusRequest("rejected")' class='btn btn-danger' role="menuitem">Reject</button></li>`)
                    $('.actions ul li:nth-child(2)').hide();
                },
                onFinishing: function() {
                    if(totalInfluencers){
                        sendStatusRequest('approve');
                    }else{
                        Swal.fire(
                            '',
                            'There are no influencers found for this campaign',
                            'error'
                        )
                    }
                    
                },
                onStepChanging: function(event, currentIndex, nextIndex) {
                    if (nextIndex == 2) {
                        let rate = '{{ $data->campaignGoals->profitable }}';
                        let initValue = document.getElementById('engagement_rate') ? document.getElementById('engagement_rate').value : 0;

                        if ((rate && initValue > 100) || (rate && initValue < 0)) 
                        {
                            Swal.fire(
                                '',
                                'Please set the engagement rate amount between 0 - 100',
                                'error'
                            );
                            return false;
                        }
                        sendStatusRequest();
                    }

                    if (nextIndex == 0) {
                        $('.actions ul li:nth-child(2)').hide();
                        $('.actions ul li:nth-child(1)').show();
                    } else {
                        $('.actions ul li:nth-child(2)').show();
                        $('.actions ul li:nth-child(1)').hide();
                    }
                    return true;
                }
            });
        });
       

        function sendStatusRequest(status = null) {
            status = status || false;

            if (status == 'rejected') {
                $('#rejectedReson').modal('toggle');
                return;
            }

            let rate = '{{ $data->campaignGoals->profitable }}';
            
            let engRate = document.getElementById('eng_number') ? document.getElementById('eng_number').value : 0;
            if ((rate && engRate > 100) || (rate && engRate < 0)) {
                return alert('please add correct amout of rate')
            }
            let fullUrl = '';
            if (status == 'approve') {
                fullUrl = '{{ route('dashboard.ads.update', [':id', ':confirm']) }}';
                fullUrl = fullUrl.replace(':id', '{{ $data->id }}');
                fullUrl = fullUrl.replace(':confirm', 1);
                $('#rejectedNote').val('');
            }else{
                fullUrl = '{{ route('dashboard.ads.update', ':id') }}';
                fullUrl = fullUrl.replace(':id', '{{ $data->id }}');
            }
        
            $.ajax({
                url: fullUrl,
                type: 'POST',
                data: {
                    status: status,
                    note: document.getElementById('rejectedNote').value,
                    category_id: document.getElementById('ad-category').value,
                    engagement_rate: engRate,
                    onSite: '{{ $data->onSite }}',
                    adBudget: '{{ $data->budget }}',
                    _token: '{{ csrf_token() }}',
                    confirm:status == 'approve'?true:false
                },
                beforeSend: () => {
                    totalInfluencers = 0;
                    $('.influencer-data').html(`<div class="blocks-table d-block influencer-data">
                                        <div class="loader-wrapper">
                                            <div class="spinner-border spinner-info" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>`);
                    $('[href="#next"]').attr('disabled',true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Next..')
                },
                success: (res) => {
                    if(status == 'approve')
                    {
                        location.reload()
                    }
                    totalInfluencers = res.totalInfluencers;
                    $('.influencer-data').html(res.data);
                    $('[href="#next"]').attr('disabled',false).html('Next');
                },
                error: (err) => {
                    console.log("updateding error: ", err);
                    alert('something wrong with updateing the ad');
                    $('[href="#next"]').attr('disabled',false).html('Next');
                }
            })
        }

        function updateRejectNote($this){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Yes & Send Notifiication`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    sendUpdateNoteRequest($this,0);
                } else if (result.isDenied) {
                    sendUpdateNoteRequest($this,1);
                }
            });
           
        }

        function sendUpdateNoteRequest($this,sendNotification){
            let url = '{{ route("dashboard.ads.updateRejectNote") }}';
            $($this).attr('disabled',true).html(`<i class="fa fa-spinner fa-spin"></i> ` + $($this).text());
            $.ajax({
                type: 'POST',
                url: url,
                data: {'ad_id': '{{$data->id}}','send_notification': sendNotification,'reject_note': $('#reject-note').val()},
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
                    Swal.fire(
                        'Error!',
                        err.responseJSON.message,
                        'error'
                    );
                    $($this).attr('disabled',false).html($($this).text());
                }
            });
        }


          
      </script>
  @endsection
