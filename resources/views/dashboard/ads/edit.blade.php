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

              <div id="rejectedReson" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Rejected Note</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <textarea class="form-control" id="rejectedNote" rows="12"></textarea>
                          </div>
                          <div class="modal-footer">
                              <button onclick="sendStatusRequest()" type="button" class="btn btn-primary">Save changes</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        </section>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('main2/js/jquery.steps.min.js') }}" type="text/javascript"></script>
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
                var $this = $(this);
                var itemId = $(this).attr('id');
                let video = document.getElementById(itemId).files[0];
                let formData = new FormData();
                formData.append('file', video)
                let url = itemId == 'addImage' ? '{{ route('dashboard.ads.uploadImage', ':id') }}' : '{{ route('dashboard.ads.uploadVideo', ':id') }}';
                let addIdToURL = url.replace(':id', '{{ $data->id }}');
                $(this).prev().attr('disabled',true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Add..')
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
                                    <div class="col-md-4 col-6 mt-2">
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
                                    <div class="col-md-4 col-6 mt-2">
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
                        $this.prev().attr('disabled',false).html('Add');
                    },
                    error: (res) => {
                        let msg = res.responseJSON.err;
                        if (!msg) msg = 'Server Error!'

                        Toast.fire({
                            icon: 'error',
                            title: msg
                        });
                        $this.prev().attr('disabled',false).html('Add');

                    }
                });
            });
        });
        // to know whate steps the user currently in
        let adStatus = '{{ $data->status }}';
        let isConfirm = false;
        let totalInfluencers = 0;

            var steps = $("#wizard-basic").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                enablePagination: true,
                enableAllSteps: false,
                startIndex: 0,
                onInit: function() {
                    if (adStatus == 'pending') {
                        $('.actions ul').prepend(`<li class='list-dicration' aria-disabled="false"><button type='button' onclick='sendStatusRequest("rejected")' class='btn btn-danger' role="menuitem">Reject</button></li>`)
                    }
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
          //var isConfirm = false;
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


            function sendStatusRequest(status = null) {
                    status = status || false;

                    if (status == 'rejected') {
                        $('#rejectedReson').modal('toggle');
                        return;
                    }
                    

                    let rate = '{{ $data->campaignGoals->profitable }}';
                    let url = '{{ route('dashboard.ads.update', ':id') }}';
                    let fullUrl = url.replace(':id', '{{ $data->id }}');
                    let engRate = document.getElementById('eng_number') ? document.getElementById('eng_number').value : 0;
                    if ((rate && engRate > 100) || (rate && engRate < 0)) {
                        return alert('please add correct amout of rate')
                    }
                    if (status == 'approve') {
                        url = '{{ route('dashboard.ads.update', [':id', ':confirm']) }}';
                        urlWithId = url.replace(':id', '{{ $data->id }}');
                        fullUrl = urlWithId.replace(':confirm', 1);
                    }
                
                    $.ajax({
                        url: fullUrl,
                        type: 'POST',
                        data: {
                            status: status,
                            note: document.getElementById('rejectedNote').value,
                            category_id: document.getElementById('ad-category').value,
                            engagement_rate: engRate,
                            change: notChange,
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
                })
               
                
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

          function seeContract(content, inf_id) {
              choosen_inf_id = inf_id;
              $('#contractContent').empty();
              let obj = CKEDITOR.instances['contractContent'];
              obj.setData(content)

              $('#seeContract').modal('toggle');
          }

          function sendContract() {
              let url = '{{ route('dashboard.ads.sendContractToInfluncer', ':id') }}';
              let addId = url.replace(':id', '{{ $data->id }}');
              $.ajax({
                  url: addId,
                  data: {
                      influncers_id: choosen_inf_id,
                      date: document.getElementById('contractDate').value,
                      scenario: document.getElementById('scenario').value
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

          function getAreas(id) {
              let route = '{{ route('dashboard.countries.index', ':id') }}';
              let urlWithUpdate = route.replace(':id', id);
              $('#selectArea').empty();
              $('#selectCity').empty();

              $.ajax({
                  url: urlWithUpdate,
                  type: 'GET',
                  success: (res) => {
                      $('#selectArea').empty();

                      let select =
                          `<select id='selectAreasS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
                      $('#selectArea').append(select);
                      for (let index = 0; index < res.data.length; index++) {
                          const element = res.data[index];
                          let option = `<option value="${element.id}" >${element.name}</option>`
                          $('#selectAreasS').append(option);
                          $('#selectAreasS').append(option);
                      }
                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'server response'
                      })
                  }
              })

          }

          function getCities(id) {
              let route = '{{ route('dashboard.cities.index', ':id') }}';
              let urlWithUpdate = route.replace(':id', id);

              $.ajax({
                  url: urlWithUpdate,
                  type: 'GET',
                  success: (res) => {
                      $('#selectCity').empty();

                      let select =
                          `<select id='selectCityS' onchange="getCities(event.target.value)" class="form-control" name="" id=""></select>`
                      $('#selectCity').append(select);
                      for (let index = 0; index < res.data.length; index++) {
                          const element = res.data[index];
                          let option = `<option value="${element.id}" >${element.name}</option>`
                          $('#selectCityS').append(option);
                          $('#selectCityS').append(option);

                      }
                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'server response'
                      })
                  }
              })
          }

          function updateAddress(id) {
              if (!valdateAddress()) return;
              let route = '{{ route('dashboard.ads.updateAddress', ':id') }}';
              let url = route.replace(':id', id);
              let data = {
                  country_id: document.getElementById('selectCountryS').value,
                  city_id: document.getElementById('selectCityS').value,
                  area_id: document.getElementById('selectAreasS').value
              }
              $.ajax({
                  url: url,
                  type: 'POST',
                  data: data,
                  success: (res) => {
                      $('#selectCity').empty();
                      $('#selectArea').empty();
                      showAddress = false;
                      Toast.fire({
                          icon: 'success',
                          title: 'Address was updated'
                      })
                      $('#addressSection').hide();

                  },
                  error: (err) => {
                      Toast.fire({
                          icon: 'error',
                          title: 'Erro updateing address'
                      })
                  }
              })
          }

          function setEditValue() {
              if (!showAddress) {
                  $('#addressSection').show();
                  showAddress = true;
              } else {
                  $('#addressSection').hide();
                  showAddress = false;
              }
          }

          function valdateAddress() {
              if (!document.getElementById('selectCountryS') || !document.getElementById('selectCityS') || !document
                  .getElementById('selectAreasS')) {
                  alert('Please fill all the data');
                  return false;
              }
              return true;
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
