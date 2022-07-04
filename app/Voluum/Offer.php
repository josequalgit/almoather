<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Models\Ad;

class Offer extends Voluum{

    public function createOffer($offer_id){
        $offer = Ad::find($offer_id);

        if(!$offer){
            $error = [
                'error' => "$offer_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }

        $checkOffer = $this->checkOfferExists($offer);
        if($checkOffer){
            $voluumOffer = $this->updateOffer($offer,$checkOffer['rows'][0]['offerId']);
        }else{
            $voluumOffer = $this->insertOffer($offer);
        }

        if($voluumOffer['status']){
            $data = [
                'message' => "$offer_id Offer added Successfully",
                'status' => true,
                'data' => $voluumOffer
            ];
            $this->log($data);
            return response()->json($data, 200);
        }

        $error = [
            'error' => "$offer_id Not set",
            'status' => false,
            'data' => $voluumOffer
        ];
        $this->log($error);
        return response()->json($error, 400);

    }

    private function updateOffer($offer,$offerId){
        
        $data = $this->getOfferParams($offer,$offerId);
        $response = $this->put(Endpoints::updateOfferEndpoint($offerId),$data);
        if($response && isset($response['id'])){
            $offer->update([
                'voluum_id' => $response['id']
            ]);
            return ['status' => true,'data' => $response];
        }

        return ['status' => false,'data' => $response];
    }

    private function insertOffer($offer){
        $data = $this->getOfferParams($offer);
    
        $response = $this->post(Endpoints::offerEndpoint(),$data);
        if($response && isset($response['id'])){
            $offer->update([
                'voluum_id' => $response['id']
            ]);
            return ['status' => true,'data' => $response];
        }
        return ['status' => false,'data' => $response];
    }

    private function getOfferParams($offer,$offerId = false){
        
        $link = explode('?',trim($offer->store_link,'/'));

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
            "namePostfix"   => $offer->store . "-offer-" . $offer->id,
            "url"           => $url,
            "payout"        => [
                "type" => "AUTO"
            ],
            "currencyCode"  => "USD",
            "tags"          => [str_replace(' ','_',$offer->categories->getTranslation('name','en'))],
            "workspace"     => null,
            "conversionTrackingMethod"  => "S2S_POSTBACK_URL",
            "preferredTrackingDomain"   => "track.almuaathir.com"
        ];

        if($offerId){
            $data['id'] = $offerId;
        }

        return $data;
    }

    private function checkOfferExists($offer){
        $data = [
            'from'      => '2022-06-02T00:00:00Z',
            'filter'    => 'offer-'.$offer->id,
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