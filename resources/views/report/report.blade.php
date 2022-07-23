<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{  $offer->store }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/report.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <style>

        
    </style>
</head>

<body>
    @php
        
        $contractData = $offer->InfluencerContract()->orderBy('date','asc')->first();
        $start_date = $contractData->date->format('d/m/Y');

        $contractData = $offer->InfluencerContract()->orderBy('date','desc')->first();
        $end_date = $contractData->date->format('d/m/Y');
    @endphp
    <htmlpageheader name="page-header">
        <header class="container" style="border-bottom: 3px solid #8486AB">
            <div class="row">
                <div class="col-12 text-left">
                    <img src="{{ asset('img/avatars/almuather-logo.png') }}" alt="Almuather" class="logo">
                </div>
            </div>
        </header>

    </htmlpageheader>
    <div class="container text-right direction-rtl text-dark contract-content text-right">
        <div class="row">
            
            
            <div class="col-6">
                <h4>الحملة: {{ $offer->store }}</h4>
            </div>
            <div class="col-6">
                <h4>عدد المؤثرين: {{ $offer->InfluencerContract->count() }}</h4>
            </div>
            
            <div class="col-6">
                <h4>تاريخ بدأ الحملة: {{ $end_date }}</h4>
            </div>
            <div class="col-6">
                <h4>تاريخ نهاية الحملة: {{ $start_date }}</h4>
            </div>
            <div class="col-6">
                <h4>الميزانية: {{ number_format($offer->price_to_pay) }} ريال سعودي </h4>
            </div>

            <div class="col-6">
                <h4>عدد الزيارات: {{ number_format(12000) }}</h4>
            </div>
            <div class="col-6"></div>
            <div class="col-6">
                <h4> رابط الحملة: <a href="" target="_blank" >{{ $offer->store_link }}</a></h4>
            </div>
            <div class="clearfix"></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>الصوره</th>
                    <th>الإسم</th>
                    <th>السعر</th>
                    @if($offer->campaignGoals->profitable)
                    <th>العائد الاستثماري</th>
                    @else
                    <th>معدل التفاعل</th>
                    <th>الجمهور المتفاعل</th>
                    @endif
                    <th>تاريخ التنفيذ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offer->InfluencerContract as $item)
                    @php 
                        $price = $item->ads->ad_type == 'online' ? $item->influencers->ad_with_vat : $item->influencers->ad_onsite_price_with_vat;
                    @endphp
                    <tr>
                        <td>
                            <div class="thumb">
                                <img class="img-fluid inf-image" src="{{ $item->influencers->users->infulncerImage['url'] }}" alt="">
                            </div>
                        </td>
                        <td>{{ $item->influencers->nick_name }}</td>
                        <td>{{ number_format($price) }}</td>
                        @if($offer->campaignGoals->profitable)
                            <td>{{ $item->revenu ?? 0 }}%</td>
                        @else
                            <td>{{ $item->revenu ?? 0 }}%</td>
                            <td>{{ $item->af ?? 0 }}</td>
                        @endif
                        
                        <td>{{ $item->date->format('d/m/Y') }}</td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
        <div id="chart"></div>
        <div class="chart-img">
            <img src="" id="chart1" alt="">
        </div>
    </div>
    
    <htmlpagefooter name="page-footer">
        <footer class="container" style="margin-top: 10px;border-top: 3px solid #8486AB;font-size: 12px">
            <div class="row">
                <div class="col-6 text-left footer-en">
                    <p>Almuaathir Advertising Company</p>
                    <p>Saudi Arabia - Riyadh,Al Qairawan Dist</p>
                    <p>King Salman Bin Abdulaziz Rd</p>
                    <p>Building No. 3954</p>
                    <p>Tel: +966558717989</p>
                    <p>info@Almuaathir.com</p>
                    <p>B.O.Box: 11799</p>
                </div>
                <div class="col-6 text-right">
                    <p>شركة المؤثر للدعاية والإعلان</p>
                    <p>المملكة العربية السعودية - الرياض</p>
                    <p>حى القيروان- طريق الملك سلمان بن عبدالعزيز </p>
                    <p>مبنى رقم 3954</p>
                    <p>هاتف : +966558717989</p>
                    <p>info@Almuaathir.com</p>
                    <p>ص . ب : 11799</p>
                </div>
                <div class="clearfix"></div>
                <div class="col-12">
                    <p class="text-center"><a href="www.almuaathir.com" target="_blank" class="website-link">
                            www.almuaathir.com</a></p>
                </div>
            </div>
        </footer>
    </htmlpagefooter>

</body>

</html>
