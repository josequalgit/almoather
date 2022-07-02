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
                <div class="card-body  influencer-data">
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

            @include('dashboard.ads.include.modal')

          </div>
      </section>
  </div>
@endsection

@section('scripts')
    @include('dashboard.ads.include.javascript')
    <script>
        $(function(){
            $('#ad-type').attr('disabled',true);
            $('#ad-category').attr('disabled',true);
            $('#eng_number').attr('disabled',true);
        });
    </script>
@endsection
