<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <style>

        *, *::before, *::after {
            box-sizing: border-box;
        }

        .text-left {
            text-align: left !important;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .col-6 {
            float: left;
            width: 50%;
        }

        .col-12 {
            width: 100%;
        }

        .text-center {
            text-align: center !important;
        }

        .text-dark {
            color: #394c62 !important;
        }

        .text-right {
            text-align: right !important;
        }


        .col-6,
        .col-12 {
            position: relative;
        }

        body {
            font-family: 'Amiri','Geneva','sans-serif';
        }

        .direction-rtl {
            direction: rtl;
        }

        .logo {
            width: 250px;
        }

        a.website-link {
            font-size: 12px;
            font-weight: bold;
            color: #8486AB;
            text-decoration: underline;
        }

        .contract-content {
            position: relative;
        }

        @page {
            header: page-header; 
            footer: page-footer;
            background: url("{{asset('img/avatars/pdf-bg.jpg')}}") no-repeat 0 0;
            background-repeat: no-repeat;
            background-position: top right;

        }
        .clearfix{
            clear: both;
        }

        footer p{
            line-height: 23px;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        <header class="container" style="border-bottom: 3px solid #8486AB">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('img/avatars/almuather-logo.png') }}" alt="Almuather" class="logo">
                </div>
            </div>
        </header>

    </htmlpageheader>
    <div class="container text-right direction-rtl text-dark contract-content">
        {!! $contract !!}
    </div>
    <htmlpagefooter name="page-footer">
        <footer class="container" style="margin-top: 10px;border-top: 3px solid #8486AB;font-size: 12px">
            <div class="row">
                <div class="col-6 text-left footer-en">
                    <p>Almuaathir Advertising Company</p>
                    <p>Saudi Arabia - Riyadh,Al Qairawan Dist. ,</p>
                    <p>King Salman Bin Abdulaziz Rd. ,</p>
                    <p>Building No. 3954.</p>
                    <p>Tel : +966558717989</p>
                    <p>info@Almuaathir.com</p>
                    <p>B.O.Box : 11799</p>
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
