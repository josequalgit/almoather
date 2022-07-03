<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Models\Ad;

class Offer extends Voluum{

    public function createOffer($campaign_id){
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
        $checkCampaign = $this->checkOfferExists($campaign);
        if($checkCampaign){
            $row = $response['rows'][0];
            $this->updateOffer($campaign,$row['offerId']);
        }else{
            $this->insertOffer($campaign,$campaignGoalProfitable);
        }

        $error = [
            'error' => "$influencer_id Not set",
            'status' => false,
            'data' => $response
        ];
        $this->log($error);
        return response()->json($error, 400);

    }

    private function updateOffer($campaign,$offerId,$profitable){
        $data = $this->getOfferParams($campaign,$offerId);
    
        $response = $this->put(Endpoints::offerEndpoint(),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            $campaign->update([
                'voluum_id' => $campaign
            ]);
            return isset($campaign) ? $response : false;
        }

        return false;
    }

    private function getOfferParams($campaign,$offerId = false){
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

        if($offerId){
            $data['id'] = $offerId;
        }

        return $data;
    }

    private function insertOffer($campaign,$profitable){
        $data = $this->getOfferParams($campaign);
    
        $response = $this->post(Endpoints::offerEndpoint(),$data);
        dd($response);


    }

    private function checkOfferExists($campaign){
        $data = [
            'from'      => '2022-06-02T00:00:00Z',
            'filter'    => 'offer-'.$campaign->id,
            'groupBy'   => 'offer',
            'offset'    => 0,
            'limit'     => 1,
            'include'   => 'active'
        ];

        $response = $this->get(Endpoints::reportEndpoint(),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            return isset($row['offerId']) ? $response : false;
        }

        return false;

    }
}