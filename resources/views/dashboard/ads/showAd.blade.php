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
                      <p class="mb-0">Ad Details</p>
                  </div>
                  <hr class="w-100 mt-1">
              </div>

              <div class="card-body">
                  <form id="ad_details_from" action="/" class="campaign-form">
                        <div class="row">
                            <div class="col" id="wizard-basic">
                                @include('dashboard.ads.include.campaigns')
                                @include('dashboard.ads.include.content')
                                @include('dashboard.ads.include.influencers')
                                @if ($data->status == 'choosing_influencer')
                                <div class="d-flex justify-content-center">
                                    <button  type="button" onclick="seeContract(true)" class="btn btn-primary w-25">
                                        Send Contract To All
                                    </button>
                                </div>
                                    
                                @endif
                            </div>
                        </div>
                  </form>
              </div>
          </div>

            <div id="unchosen_inf" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Matched Inulncers</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col">
                                <div class="user-dashboard-info-box table-responsive mb-0 bg-white  shadow-sm">
                                    <table class="table manage-candidates-top mb-0">

                                        <tbody>
                                            @foreach ($unMatched as $item)
                                                <tr class="candidates-list bg-dnager">
                                                    <td class="title">
                                                        <div class="thumb">

                                                            <img class="img-fluid"
                                                                src="{{ $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null }}"
                                                                alt="">
                                                        </div>
                                                        <div class="candidate-list-details">
                                                            <div class="candidate-list-info">
                                                                <div class="candidate-list-title">
                                                                    <h5 class="mb-0">
                                                                        {{ $item->influencers->first_name }}
                                                                        {{ $item->influencers->middle_name }}
                                                                        {{ $item->influencers->last_name }}</h5>
                                                                    <span
                                                                        style="font-size:12px;">{{ $item->match }}%</span><br />
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col">
                                                            <button style="background:none; border:none;"
                                                                onclick="replaceInfluncer('{{ $item->influencers->id }}',)"
                                                                class="float-right" href="http://" target="_blank"
                                                                rel="noopener noreferrer">
                                                                <h5>chose</i></h5>
                                                            </button>
                                                                

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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

           
            <div id="reject_ad_contract" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>Add Reject Reason</p>
                            <textarea id="reject_ad_contract_input" class="form-control" id="rejectedNote" rows="12"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="sendAdContractStatus('reject')"
                                class="btn btn-primary">Send</button>
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
                 $('#ad-category').append(`<option value="${element.id}">${element.name.en}</option>`) 
              });
          }).change();

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
      // to know whate steps the user currently in
      let userCurrentStep = 0;
      let countMatches = '{{ count($matches) }}';
      let adStatus = '{{ $data->status }}';
      let isConfirm = false;
      if (adStatus != 'pending') {
          userCurrentStep = 1;
      }
      if (countMatches > 0) {
          userCurrentStep = 2
      }
     

      $('#addressSection').hide();
      let ad_id = '{{ $data->id }}';

        let getLocalData = localStorage.getItem('rateData');
        if (getLocalData) {
            getLocalData = JSON.parse(getLocalData);
            let getRate = getLocalData[ad_id];
            if (getRate) {
                document.getElementById('engagement_rate').value = getRate;
            }
        }


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



        function getUnchosenInfulncers(inf_id) {
            removed_inf = inf_id;

            return $('#unchosen_inf').modal('toggle');
        }

        function replaceInfluncer(inf_id, ) {
            let url = '{{ route('dashboard.ads.changeMatch', [':id', ':removed_inf', ':chosen_inf']) }}';
            let changeId = url.replace(':id', '{{ $data->id }}');
            let changeInf = changeId.replace(':removed_inf', removed_inf);
            let chosenInf = changeInf.replace(':chosen_inf', inf_id)

            $.ajax({
                type: 'GET',
                url: chosenInf,
                success: (res) => {
                    if (res.status != 200) {
                        return alert(res.msg)
                    }
                    location.reload();
                },
                error: (err) => {
                    console.log('delete admin Error')
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
