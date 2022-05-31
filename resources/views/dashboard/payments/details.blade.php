@extends('dashboard.layout.index')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- app invoice View Page -->
            <section class="invoice-view-wrapper">
                <div class="row">
                    <!-- invoice view page -->
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-body pb-0 mx-25">
                                <!-- header section -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <span class="invoice-number mr-50">Invoice#</span>
                                        <span>{{ $data->trans_id }}</span>
                                    </div>
                                    <div class="col-lg-8 col-md-12">
                                        <div class="d-flex align-items-center justify-content-lg-end flex-wrap">
                                            {{-- <div class="mr-3">
                                                <small class="text-muted">Issue Date:</small>
                                                <span>08/10/2019</span>
                                            </div> --}}
                                            <div>
                                                <small class="text-muted">Due Date:</small>
                                                <span>{{ $data->created_at->format('Y/m/d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- logo and title -->
                                <div class="row my-2 my-sm-3">
                                    <div class="col-sm-6 col-12 text-center text-sm-left order-2 order-sm-1">
                                        <h4 class="text-primary">Invoice</h4>
                                        <span>Publishing Ad</span>
                                    </div>
                                    <div class="col-sm-6 col-12 text-center text-sm-right order-1 order-sm-2 d-sm-flex justify-content-end mb-1 mb-sm-0">
                                        {{-- <img src="../../../app-assets/images/pages/pixinvent-logo.png" alt="logo" height="46" width="164"> --}}
                                        <img class="logo" src="{{ asset('main2/images/logo/logo.png') }}"  alt="logo" width="100"/>

                                    </div>
                                </div>
                                <hr>
                                <!-- invoice address and contact -->
                                <div class="row invoice-info">
                                    <div class="col-sm-6 col-12 mt-1">
                                        <h6 class="invoice-from">Customer Info</h6>
                                        <div class="mb-1">
                                            <span>Name: {{ $data->ads->customers->full_name }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Location :{{ $data->ads->customers->citys->name .' '.$data->ads->customers->regions->name.' '.$data->ads->customers->countrys->name}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Email: {{ $data->ads->customers->users->email }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Phone: {{ $data->ads->customers->users->phone }}</span>
                                        </div>
                                    </div>
                                  
                                </div>
                                <hr>
                            </div>
                            <!-- product details table-->
                            <div class="invoice-product-details table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th scope="col">Item</th>
                                            <th scope="col">Type</th>
                                            <th scope="col" class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->ads->store }}</td>
                                            <td style="text-transform:uppercase">{{ str_replace('_',' ',$data->type) }}</td>
                                            <td class="text-primary text-right font-weight-bold">${{ $data->amount }}</td>
                                        </tr>
                                     
                                    </tbody>
                                </table>
                            </div>

                            <!-- invoice subtotal -->
                            <div class="card-body pt-0 mx-25">
                                <hr>
                                <div class="row">
                                    <div class="col-4 col-sm-6 col-12 mt-75">
                                        <p>Thanks for your business.</p>
                                    </div>
                                    <div class="col-8 col-sm-6 col-12 d-flex justify-content-end mt-75">
                                        <div class="invoice-subtotal">
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Subtotal</span>
                                                <span class="invoice-value"> ${{$data->amount}}</span>
                                            </div>
                                            {{-- <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Discount</span>
                                                <span class="invoice-value">- $09.60</span>
                                            </div>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Tax</span>
                                                <span class="invoice-value">21%</span>
                                            </div> --}}
                                            <hr>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Invoice Total </span>
                                                <span class="invoice-value"> ${{$data->amount}}</span>
                                            </div>
                                            {{-- <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Paid to date</span>
                                                <span class="invoice-value">$00.00</span>
                                            </div>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Balance (USD)</span>
                                                <span class="invoice-value">$10,953</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- invoice action  -->
                    <div class="col-xl-3 col-md-4 col-12">
                        <div class="card invoice-action-wrapper shadow-none border">
                            <div class="card-body">
                                <h5 class="text-center">
                                   Action
                                </h5>
                                <div class="invoice-action-btn">
                                    <button class="invoice-print btn btn-success btn-block">
                                        <i class='bx bx-printer'></i>
                                        <span>Print</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

@endsection

@section('scripts')    

<script>
    $(".invoice-print").on("click", function () {
        var mywindow = window.open( "", "new div", "height=300,width=600" );
        mywindow.document.write( "<html><head><title></title>" );
            mywindow.document.write( '<link rel="stylesheet" type="text/css" href="{{ asset("main2/css/bootstrap.css") }}">' );
        mywindow.document.write( '<link rel=\"stylesheet\" href="{{ asset("main2/pages/css/app-invoice.css") }}" type=\"text/css\"/>' );
        mywindow.document.write( '<style type="text/css">@page{margin:0;size:auto}</style>' );
        mywindow.document.write( "</head><body>" );
        mywindow.document.write( `<div>
            <!-- app invoice View Page -->
            <section class="invoice-view-wrapper">
                <div class="row">
                    <!-- invoice view page -->
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-body pb-0 mx-25">
                                <!-- header section -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <span class="invoice-number mr-50">Invoice#</span>
                                        <span>{{ $data->trans_id }}</span>
                                    </div>
                                    <div class="col-lg-8 col-md-12">
                                        <div class="d-flex align-items-center justify-content-lg-end flex-wrap">
                                            {{-- <div class="mr-3">
                                                <small class="text-muted">Issue Date:</small>
                                                <span>08/10/2019</span>
                                            </div> --}}
                                            <div>
                                                <small class="text-muted">Due Date:</small>
                                                <span>{{ $data->created_at->format('Y/m/d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- logo and title -->
                                <div class="row my-2 my-sm-3">
                                    <div class="col-sm-6 col-12 text-center text-sm-left order-2 order-sm-1">
                                        <h4 class="text-primary">Invoice</h4>
                                        <span>Publishing Ad</span>
                                    </div>
                                    <div class="col-sm-6 col-12 text-center text-sm-right order-1 order-sm-2 d-sm-flex justify-content-end mb-1 mb-sm-0">
                                        {{-- <img src="../../../app-assets/images/pages/pixinvent-logo.png" alt="logo" height="46" width="164"> --}}
                                        <img class="logo" src="{{ asset('main2/images/logo/logo.png') }}"  alt="logo" width="100"/>

                                    </div>
                                </div>
                                <hr>
                                <!-- invoice address and contact -->
                                <div class="row invoice-info">
                                    <div class="col-sm-6 col-12 mt-1">
                                        <h6 class="invoice-from">Customer Info</h6>
                                        <div class="mb-1">
                                            <span>Name: {{ $data->ads->customers->full_name }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Location :{{ $data->ads->customers->citys->name .' '.$data->ads->customers->regions->name.' '.$data->ads->customers->countrys->name}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Email: {{ $data->ads->customers->users->email }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span>Phone: {{ $data->ads->customers->users->phone }}</span>
                                        </div>
                                    </div>
                                  
                                </div>
                                <hr>
                            </div>
                            <!-- product details table-->
                            <div class="invoice-product-details table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th scope="col">Item</th>
                                            <th scope="col">Type</th>
                                            <th scope="col" class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->ads->store }}</td>
                                            <td style="text-transform:uppercase">{{ str_replace('_',' ',$data->type) }}</td>
                                            <td class="text-primary text-right font-weight-bold">${{ $data->amount }}</td>
                                        </tr>
                                     
                                    </tbody>
                                </table>
                            </div>

                            <!-- invoice subtotal -->
                            <div class="card-body pt-0 mx-25">
                                <hr>
                                <div class="row">
                                    <div class="col-4 col-sm-6 col-12 mt-75">
                                        <p>Thanks for your business.</p>
                                    </div>
                                    <div class="col-8 col-sm-6 col-12 d-flex justify-content-end mt-75">
                                        <div class="invoice-subtotal">
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Subtotal</span>
                                                <span class="invoice-value"> ${{$data->amount}}</span>
                                            </div>
                                            {{-- <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Discount</span>
                                                <span class="invoice-value">- $09.60</span>
                                            </div>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Tax</span>
                                                <span class="invoice-value">21%</span>
                                            </div> --}}
                                            <hr>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Invoice Total </span>
                                                <span class="invoice-value"> ${{$data->amount}}</span>
                                            </div>
                                            {{-- <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Paid to date</span>
                                                <span class="invoice-value">$00.00</span>
                                            </div>
                                            <div class="invoice-calc d-flex justify-content-between">
                                                <span class="invoice-title">Balance (USD)</span>
                                                <span class="invoice-value">$10,953</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
                </div>
            </section>

        </div>` );
        mywindow.document.write( "</body></html>" );
        setTimeout(function () {
        mywindow.print();
    }, 500);
   })
</script>
@endsection