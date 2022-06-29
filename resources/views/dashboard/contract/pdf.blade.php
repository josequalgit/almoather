<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>

    <style>

*, *::before, *::after {
    box-sizing: border-box;
}
        

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .text-left {
            text-align: left !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 1140px;
        }

        .mb-0, .my-0 {
    margin-bottom: 0 !important;
    margin-top: 6px;
    font-weight: 500;
}

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
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
            padding-right: 15px;
            padding-left: 15px;
        }

        body {
            background-color: #fff;
            font-family: 'Rubik', 'Tajawal';
            background-repeat: no-repeat;
            background-position: top right;
        }

        .direction-rtl {
            direction: rtl;
        }

        .logo {
            width: 250px;
        }

        .devider {
            border-top: 3px solid #8486AB;
        }

        a.website-link {
            font-size: 20px;
            font-weight: bold;
            color: #8486AB;
            text-decoration: underline;
        }

        .contract-content {
            position: relative;
        }

        .contract-content:after {
            content: "";
            background-image: url(../../img/avatars/logo-almuaather.png);
            opacity: 0.15;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 100%;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('img/avatars/pdf-bg.png') }}')">
    <htmlpageheader name="page-header">
        <header class="container">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('img/avatars/almuather-logo.png') }}" alt="Almuather" class="logo">
                </div>
            </div>
            <hr class="devider">
        </header>

    </htmlpageheader>
    <div class="container text-right direction-rtl text-dark contract-content">
        {!! $contract !!}
    </div>
    <htmlpagefooter name="page-footer">
        <footer class="container">
            <hr class="devider">
            <div class="row">
                <div class="col-6 text-left">
                    <p class="mb-0">Almuaathir Advertising Company</p>
                    <p class="mb-0">Saudi Arabia - Riyadh,Al Qairawan Dist. ,</p>
                    <p class="mb-0">King Salman Bin Abdulaziz Rd. ,</p>
                    <p class="mb-0">Building No. 3954.</p>
                    <p class="mb-0">Tel : +966558717989</p>
                    <p class="mb-0">info@Almuaathir.com</p>
                    <p class="mb-0">B.O.Box : 11799</p>
                </div>
                <div class="col-6 text-right">
                    <p class="mb-0">شركة المؤثر للدعاية والإعلان</p>
                    <p class="mb-0">المملكة العربية السعودية - الرياض</p>
                    <p class="mb-0">حى القيروان- طريق الملك سلمان بن عبدالعزيز </p>
                    <p class="mb-0">مبنى رقم 3954</p>
                    <p class="mb-0">هاتف : +966558717989</p>
                    <p class="mb-0">info@Almuaathir.com</p>
                    <p class="mb-0">ص . ب : 11799</p>
                </div>
                <div class="col-12">
                    <p class="text-center"><a href="www.almuaathir.com" target="_blank" class="website-link">
                            www.almuaathir.com</a></p>
                </div>
            </div>
        </footer>
    </htmlpagefooter>
</body>

</html>
