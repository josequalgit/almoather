@extends('dashboard.layout.index')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <form method="post" enctype="multipart/form-data" id="influencers-form" action="{{ route('dashboard.influncers.updateStatus', $data->id) }}">                  
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
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('main2/new-design/jquery.steps.css') }}">
<link rel="stylesheet" href="{{ asset('main2/new-design/style.css') }}">
<link rel="stylesheet" href="{{ asset('js/intl-tel-input/css/intlTelInput.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('main2/js/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/intl-tel-input/css/intlTelInput-jquery.min.js') }}" type="text/javascript"></script>

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

            $('#status').on('change',function(){
                if($(this).val() == 'rejected'){
                    $('.reject-wrapper').show();
                }else{
                    $('.reject-wrapper').hide();
                }
            });
            
        });

        $(document).on("change",".uploadFile", function(){
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return;
    
            if (/^image/.test( files[0].type)){
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);
    
                reader.onloadend = function(){
                    uploadFile.closest(".imgUp").find('.image-preview').attr("src", this.result);
                }
            }
        
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
            onInit: function() {
                
            },
            onFinishing: function() {
                saveInfluencersData();
            },
            onStepChanging: function(event, currentIndex, nextIndex) {
                let inputs = $('.required:visible');
                $('.error-validation').remove();
                let valid = true; 
                for(var i = 0; i < inputs.length;i++){
                    if(!$(inputs[i]).val()){
                        $(inputs[i]).closest('.form-group').append(`<p class="mb-0 error-validation text-danger">This field is required</p>`);
                        valid = false;
                    }
                }
               return valid;
            }
        });

        function saveInfluencersData() {
            var formData = new FormData($('#influencers-form')[0]);
            $.ajax({
                url: $('#influencers-form').attr('action'),
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
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
                        )
                    }
                    
                },
                error: (err) => {
                    console.log(err)
                    Swal.fire(
                        'Error!',
                        err.responseJSON.message,
                        'error'
                    )
                }
            });
        }

        function sendStatusRequest() {
            var cate = [];
            $('input[name="categories[]"]:checked').each(function() {
                cate[cate.length] = (this.checked ? $(this).val() : "");
            });
            
        }
    </script>
@endsection
