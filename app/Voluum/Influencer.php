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

        $checkInfluencer = $this->checkInfluencerExists($influencer);
        if($checkInfluencer){
            $voluumInfluencer = $this->updateInfluencer($influencer,$checkInfluencer['rows'][0]['trafficSourceId']);
        }else{
            $voluumInfluencer = $this->insertInfluencer($influencer);
        }
        
        if($voluumInfluencer['status']){
            $data = [
                'message' => "$influencer_id Influencer added Successfully",
                'status' => true,
                'data' => $voluumInfluencer
            ];
            $this->log($data);
            return response()->json($data, 200);
        }
       
        $error = [
            'error' => "$influencer_id Influencer Not set",
            'status' => false,
            'data' => $voluumInfluencer
        ];
        $this->log($error);
        return response()->json($error, 400);
    }

    private function checkInfluencerExists($influencer){

        $data = [
            'groupBy' => 'traffic-source',
            'from' => '2022-06-02T00:00:00Z',
            'filter' => 'almuaathir_id_'.$influencer->id,
            'offset' => 0,
            'limit' => 1,
            'include'   => 'active'
        ];

        $response = $this->get(Endpoints::reportEndpoint(),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            return isset($row['trafficSourceId']) ? $response : false;
        }

        return false;
    }

    private function getInfluencerParameters($influencer,$voluum_id = false){
        $data = [
            'name' => $influencer->nick_name,
            'impressionSpecific' => false,
            'externalIds' => [],
            'currencyCode' => 'SAR',
            'customVariables' => [
                [
                    'index' => 1,
                    "name" => "Almuaathir ID",
                    "parameter" => "almuaathir_id_{$influencer->id}",
                    "placeholder" => $influencer->id,
                    "trackedInReports" => true
                ]
            ],
            'workspace' => null,
            'directTracking' => false,
            'skipSendingPostback' => true,
        ];

        if($voluum_id){
            $data['id'] = $voluum_id;
        }

        return $data;
    }

    private function updateInfluencer($influencer,$voluumId){

        $data = $this->getInfluencerParameters($influencer,$voluumId);
        $response = $this->put(Endpoints::updateInfluencerEndpoint($voluumId),$data);
        if($response && isset($response['id'])){
            $influencer->update([
                'voluum_id' => $response['id']
            ]);
            return ['status' => true,'data' => $response];
        }
        
        return ['status' => false,'data' => $response];
    }

    private function insertInfluencer($influencer){
        $data = $this->getInfluencerParameters($influencer);
        $response = $this->post(Endpoints::addInfluencerEndpoint(),$data);
        if($response && isset($response['id'])){
            $influencer->update([
                'voluum_id' => $response['id']
            ]);
            return ['status' => true,'data' => $response];
        }
        
        return ['status' => false,'data' => $response];
    }
}