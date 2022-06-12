<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Models\Influncer;

class Influencer extends Voluum{

    public function addInfluencer($influencer_id){

        $influencer = Influncer::find($influencer_id);
        if(!$influencer){
            $error = [
                'error' => "$influencer_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }


        $data = [
            'name' => $influencer->full_name,
            'impressionSpecific' => false,
            'externalIds' => [],
            'currencyCode' => 'USD',
            'customVariables' => [
                'index' => 1,
                "name" => "Almuaathir ID",
                "parameter" => "almuaathir_id_{$influencer->id}",
                "placeholder" => $influencer->id,
                "trackedInReports" => false
            ],
            'workspace' => null,
            'directTracking' => false,
            'skipSendingPostback' => true,
        ];

        $this->setParams($data);
        $this->setEndpoints(Endpoints::addInfluencerEndpoint());
        $response = $this->postRequest();
        dd($response);
    }

    function getInfluencer($influencer){

        $data = [
            'groupBy' => 'traffic-source',
            'from' => '2022-06-02T00:00:00Z',
            'filter' => 'almuaathir_id',
            'offset' => 0,
            'limit' => 1,
            'column' => [
                'trafficSourceName',
                'visits',
                'suspiciousVisitsPercentage',
                'visits',
                'suspiciousVisits',
                'uniqueVisits',
                'clicks',
                'trafficSourceId',
                'visits',
                'suspiciousVisitsPercentage',
                'visits',
                'suspiciousVisits',
                'uniqueVisits',
                'clicks',
                'uniqueClicks',
                'suspiciousClicksPercentage',
                'clicks',
                'suspiciousClicks',
                'conversions',
                'revenue',
                'cost',
                'customVariable1-TS'
            ]
        ];

        $response = $this->get(Endpoints::addInfluencerEndpoint(),$data);
        dd($response);
    }
}