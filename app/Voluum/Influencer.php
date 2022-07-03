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
            $row = $checkInfluencer['rows'][0];
            $influencer->update([
                'voluum_id' => $row['trafficSourceId']
            ]);

            $this->updateInfluencer($row['trafficSourceId'],$influencer_id);
            return response()->json([
                'status' => true,
                'data' => [
                    'influencer' => $influencer->full_name,
                    'vluum_id' => $row['trafficSourceId'],
                ]
            ], 200);
        }
        
        $data = $this->getInfluencerParameters($influencer);

        $response = $this->post(Endpoints::addInfluencerEndpoint(),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            $influencer->update([
                'voluum_id' => $row['trafficSourceId']
            ]);
            return response()->json([
                'status' => true,
                'data' => [
                    'influencer' => $influencer->full_name,
                    'vluum_id' => $row['trafficSourceId'],
                ]
            ], 200);
        }
        $error = [
            'error' => "$influencer_id Not set",
            'status' => false,
            'data' => $response
        ];
        $this->log($error);
        return response()->json($error, 400);
    }

    function checkInfluencerExists($influencer){

        $data = [
            'groupBy' => 'traffic-source',
            'from' => '2022-06-02T00:00:00Z',
            'filter' => 'almuaathir_id_'.$influencer->id,
            'offset' => 0,
            'limit' => 1
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

    public function updateInfluencer($influencer_id){

        $influencer = Influncer::find($influencer_id);
        if(!$influencer){
            $error = [
                'error' => "$influencer_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }

        $data = $this->getInfluencerParameters($influencer,$influencer->voluum_id);
        $response = $this->put(Endpoints::updateInfluencerEndpoint($influencer->voluum_id),$data);
        if($response && isset($response['rows']) && !empty($response['rows'])){
            $row = $response['rows'][0];
            $influencer->update([
                'voluum_id' => $row['trafficSourceId']
            ]);
            return response()->json([
                'status' => true,
                'data' => [
                    'influencer' => $influencer->nick_name,
                    'vluum_id' => $row['trafficSourceId'],
                ]
            ], 200);
        }
        $error = [
            'error' => "$influencer_id Not set",
            'status' => false,
            'data' => $response
        ];
        $this->log($error);
        return response()->json($error, 404);
    }
}