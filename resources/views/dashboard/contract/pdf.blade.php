<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? ''}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('main2/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body style="background-image: url('{{ asset('img/avatars/pdf-bg.png'); }}')">
    <htmlpageheader name="page-header">
        <header class="container">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('img/avatars/almuather-logo.png'); }}" alt="Almuather" class="logo">
                </div>
            </div>
            <hr class="devider">
        </header>
        
    </htmlpageheader>
    <div class="container text-right direction-rtl text-dark contract-content" >
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
                <div class="col-12"><p class="text-center"><a href="www.almuaathir.com" target="_blank" class="website-link"> www.almuaathir.com</a></p></div>
            </div>
        </footer>
    </htmlpagefooter>
</body>
</html>