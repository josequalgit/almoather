@extends('dashboard.layout.index')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.admins.edit', $data->id) }}">                  
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <p class="mb-0">Influencer: {{ $data->full_name }}</p>
                            </div>
                            <hr class="w-100">
                        </div>
                        <div class="card-body card-dashboard">
                            <div id="wizard">
                                @include('dashboard.influncers.includes.personal-information')
                                @include('dashboard.influncers.includes.media')
                                @include('dashboard.influncers.includes.delivery')
                                @include('dashboard.influncers.includes.billing')
                                @include('dashboard.influncers.includes.category')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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

@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">
<link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('main2/js/jquery.steps.min.js') }}" type="text/javascript"></script>

    <script>

        $(function(){
            $('#country_id').on('change',function() {
                $('#region_id').html('');
                var route = '{{ route("regions.getRegion",":country"); }}';
                route = route.replace(':country',$(this).val());
                $.get(route,function(res) {
                    if(res.status == 200){
                        let options = ``;
                        let value = $('region_id').attr('data-value');
                        res.data.forEach((item, index)=>{
                            options += `<option value="${item.id}" ${ value == item.id ? 'selected' : '' }>${item.name.en}</option>`;
                        });
                        $('#region_id').html(options).change();
                    }
                },'json');
            }).change();

            $('#region_id').on('change',function() {
                $('#city_id,#rep_city').html('');
                var route = '{{ route("cities.getCities",":city"); }}';
                route = route.replace(':city',$(this).val());
                $.get(route,function(res) {
                    if(res.status == 200){
                        let options = ``;
                        let optionsDelivery = ``;
                        let value = $('#city_id').attr('data-value');
                        let valueDelivert = $('#rep_city').attr('data-value');
                        res.data.forEach((item, index)=>{
                            options += `<option value="${item.id}" ${ value == item.id ? 'selected' : '' }>${item.name}</option>`;
                            optionsDelivery += `<option value="${item.id}" ${ valueDelivert == item.id ? 'selected' : '' }>${item.name}</option>`;
                        });
                        $('#city_id').html(options);
                        $('#rep_city').html(optionsDelivery);
                    }
                },'json');
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#wizard").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            enablePagination: true,
            enableAllSteps: true,
            startIndex: 0,
            onInit: function() {
                $('.actions ul li:nth-child(2)').hide();
            },
            onFinishing: function() {
                if(totalInfluencers){
                    changeStatus();
                }else{
                    Swal.fire(
                        '',
                        'There are no influencers found for this campaign',
                        'error'
                    )
                }
                
            },
            onStepChanging: function(event, currentIndex, nextIndex) {
               return true;
            }
        });

        function changeStatus() {
            let statusValue = document.getElementById('status').value;

            if (statusValue == 'rejected') {
                $('#rejectedReson').modal('toggle');
            } else {
                sendStatusRequest();
            }
        }

        function sendStatusRequest() {
            var cate = [];
            $('input[name="categories[]"]:checked').each(function() {
                cate[cate.length] = (this.checked ? $(this).val() : "");
            });
            let url = '{{ route('dashboard.influncers.updateStatus', ':id') }}';
            let urlWithId = url.replace(':id', '{{ $data->id }}');
            $.ajax({
                url: urlWithId,
                type: 'POST',
                data: {
                    status: document.getElementById('status').value,
                    note: document.getElementById('rejectedNote').value,
                    categories: cate
                },
                success: (res) => {
                    let url = '{{ route('dashboard.influncers.index') }}'
                    window.location.href = url;
                },
                error: (err) => {
                    alert(err)
                }
            })
        }
    </script>
@endsection
