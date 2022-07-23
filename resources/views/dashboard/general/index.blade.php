@extends('dashboard.layout.index')
@section('content')
<div class="app-content content">
<div class="content-wrapper">
    <section id="basic-input">
        {{-- @can('Edit Contact Us') --}}
        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.generals.update') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="mb-0">General Settings</p>
                        </div>
                    </div>
                    
                    <hr class="w-100">
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert"> There is something wrong
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="campaign_first_payment_period">Campaign active days before first payment</label>
                                    <input value="{{ $data->campaign_first_payment_period ?? config('global.CAMPAIGN_FIRST_PAYMENT_PERIOD') }}" name="expired_info[campaign_first_payment_period]" type="number" class="form-control" id="campaign_first_payment_period" placeholder="Campaign active days before first payment" min="1">
                                    <div id="campaign_first_payment_periodHelp" class="form-text text-help">The number of days the campaign will remain active before it is canceled if the customer didn't pay the first payment</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="campaign_first_payment_reminder">Campaign reminder to pay first payment</label>
                                    <input value="{{ $data->campaign_first_payment_reminder ?? config('global.CAMPAIGN_FIRST_PAYMENT_REMINDER') }}" name="expired_info[campaign_first_payment_reminder]" type="number" class="form-control" id="campaign_first_payment_reminder" placeholder="Campaign reminder to pay first payment" min="1">
                                    <div id="campaign_first_payment_reminderHelp" class="form-text text-help">After this number of days, the user will receive a daily notification to remind him to pay the first payment</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="campaign_full_payment_period">Campaign active days after full payment</label>
                                    <input value="{{ $data->campaign_full_payment_period ?? config('global.CAMPAIGN_FULL_PAYMENT_PERIOD') }}" name="expired_info[campaign_full_payment_period]" type="number" class="form-control" id="campaign_full_payment_period" placeholder="Campaign active days before full payment" min="1">
                                    <div id="campaign_full_payment_periodHelp" class="form-text text-help">The number of days the campaign will remain active before it is canceled if the customer didn't pay the full payment</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="campaign_full_payment_reminder">Campaign reminder to pay full payment</label>
                                    <input value="{{ $data->campaign_full_payment_reminder ?? config('global.CAMPAIGN_FIRST_PAYMENT_REMINDER') }}" name="expired_info[campaign_full_payment_reminder]" type="number" class="form-control" id="campaign_full_payment_reminder" placeholder="Campaign reminder to pay full payment" min="1">
                                    <div id="campaign_full_payment_reminder" class="form-text text-help">After this number of days, the user will receive a daily notification to remind him to pay the full payment</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="campaign_full_payment_reminder">Influencer period before cancel contract</label>
                                    <input value="{{ $data->campaign_influencer_contract_cancelled ?? config('global.CAMPAIGN_INFLUENCER_CONTRACT_CANCELLED') }}" name="expired_info[campaign_influencer_contract_cancelled]" type="number" class="form-control" id="campaign_full_payment_reminder" placeholder="Campaign reminder to pay full payment" min="1">
                                    <div id="campaign_full_payment_reminder" class="form-text text-help">The number of days the contract will remain active before it is canceled if the influencer didn't accept or reject it</div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tax">Tax Value</label>
                                    <input value="{{ $tax->value ?? config('global.TAX') }}" name="tax" type="number" class="form-control" id="tax" placeholder="Tax Value" min="0" max="100">
                                </div>

                            </div>
                            <hr/>
                              <button type="submit" class="btn btn-secondary float-right">Update</button>
                        </div>
                       
                    </div>
            </div>
        </div>
        </form>
        {{-- @endcan --}}
    
    </section>

</div>


      
</div>

@endsection