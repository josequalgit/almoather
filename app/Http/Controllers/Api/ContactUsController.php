<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    function contactInformation(){

        $data = [
            'name' => 'شركة المؤثر للدعاية والإعلان',
            'location' => 'المملكة العربية السعودية - الرياض',
            'address' => 'حى القيروان- طريق الملك سلمان بن عبدالعزيز',
            'building' => 'مبنى رقم 3954',
            'phone' => '+966558717989',
            'email' => 'info@Almuaathir.com',
            'boxOffice' => 'B.O.Box : 11799',
            'socialMedia' => [
                [
                    'link' => 'https://snapchat.com/',
                    'type' => 4
                ],
                [
                    'link' => 'https://facebook.com/',
                    'type' => 1
                ],
                [
                    'link' => 'https://twitter.com/',
                    'type' => 2
                ],
                [
                    'link' => 'https://youtube.com/',
                    'type' => 5
                ],
                [
                    'link' => 'https://instagram.com/',
                    'type' => 3
                ]
            ],
        ];

        return response()->json([
            'status' => config('global.OK_STATUS'),
            'data'=> $data,
        ],config('global.OK_STATUS'));
    }

    function store(){

    }
}
