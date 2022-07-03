<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Models\Ad;

class Offers extends Voluum{

    function createOffer($campaign_id){
        $campaign = Ad::find($campaign_id);

        

        if(!$campaign){
            $error = [
                'error' => "$campaign_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }

        $campaignGoalProfitable = $campaign->campaignGoals->profitable;
dd($this->createCampaign($campaign,$campaignGoalProfitable));
        $checkCampaign = $this->checkOfferExists($campaign);
        if($checkCampaign){
            $this->updateCampaign($campaign);
        }else{
            $this->createCampaign($campaign,$campaignGoalProfitable);
        }

        

    }

    private function createCampaign($campaign,$profitable){
        $link = explode('?',trim($campaign->store_link,'/'));

        $params = [];
        if(isset($link[1])){
            $linkParams = explode('&',$link[1]);
            foreach($linkParams as $param){
                $param = explode('=',$param);
                $params[$param[0]] = isset($param[1]) ? $param[1] : '';
            }
        }
        $url = urldecode($link[0] . "?" . http_build_query(
            array_merge($params,['cid' => '{clickid}','country' => '{country}','city' => '{city}'])
        ));

        $data = [
            "namePostfix"   => $campaign->store . "-offer-" . $campaign->id,
            "url"           => $url,
            "payout"        => [
                "type" => "AUTO"
            ],
            "currencyCode"  => "USD",
            "tags"          => [str_replace(' ','_',$campaign->categories->getTranslation('name','en'))],
            "workspace"     => null,
            "conversionTrackingMethod"  => "S2S_POSTBACK_URL",
            "preferredTrackingDomain"   => "courcusesinding.com"
        ];
    
        $response = $this->post(Endpoints::offerEndpoint(),$data);
        dd($response);


    }

    private function checkOfferExists($campaign){
        $data = [
            'from'      => '2022-06-02T00:00:00Z',
            'filter'    => 'offer_'.$campaign->id,
            'groupBy'   => 'offer',
            'offset'    => 0,
            'limit'     => 1
        ];

        $response = $this->get(Endpoints::reportEndpoint(),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            return isset($row['trafficSourceId']) ? $response : false;
        }

        return false;

    }
}