<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Voluum\Influencer;
use App\Voluum\Offer;
use App\Models\InfluencerContract;
use App\Models\Ad;
use Mpdf\Mpdf;

class Report extends Voluum
{

    public function report($campaign_id){
        $offer = Ad::find($campaign_id);
        
        if(!$offer){
            $error = [
                'error' => "$campaign_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }

        $campaigns = $offer->InfluencerContract()->whereNotNull('voluum_id')->get();
        if($campaigns->count() == 0){
            $error = [
                'error' => "No campaigns found for the offer " . $offer->store,
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 401);
        }

        
        // return view('report.report',compact('offer'));
        foreach($campaigns as $campaign){
            $campaignData = $this->getInfluencerCampaignData($campaign);
           // dd($campaignData);
        }

        $chart = view('report.chart',compact('offer'))->render();
        dd($chart);

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $pdf = new mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 35,
            'margin_bottom' => 65,
            'fontDir' => array_merge($fontDirs, [
                public_path('Amiri'),
            ]),
            'fontdata' => $fontData + [
                'Amiri' => [
                    'R' => 'Amiri-Regular.ttf',
                    'I' => 'Amiri-Bold.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75
                ]
            ],
            'default_font' => 'Amiri'
        ]);
        
        $pdf->SetTitle($offer->store);
        $pdf->setAutoTopMargin = 'stretch';
        $pdf->SetDisplayMode('fullpage');
        $html = view('report.report',compact('offer'))->render();
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->SetWatermarkImage(public_path('img/avatars/logo-almuaather-full.jpg'),0.10,array(130,130));
        $pdf->showWatermarkImage = true;
        $pdf->SetDefaultBodyCSS('background', "url('".asset('img/avatars/pdf-bg.jpg')."')");
        $pdf->SetDefaultBodyCSS('background-image-resize', 6);
        $pdf->SetDefaultBodyCSS('background-position', 'top right');
        $pdf->SetDefaultBodyCSS('background-repeat', 'no-repeat');
        $pdf->WriteHTML($html);

        $pdf->Output();

       // return view('report.report',compact('offer'));
    }


    private function getInfluencerCampaignData($campaign){
        $data = [
            'from'      => '2022-06-02T00:00:00Z',
            'filter'    => 'campaign-'.$campaign->ad_id.'-'.$campaign->influencer_id,
            'groupBy'   => 'campaign',
            'offset'    => 0,
            'limit'     => 1,
            'include'   => 'active'
        ];

        $response = $this->get(Endpoints::reportEndpoint(),$data);
        
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            return isset($row['campaignId']) ? $response : false;
        }

        return false;

    }
}