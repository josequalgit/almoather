<?php
namespace App\Voluum;
use App\Voluum\Voluum;
use App\Voluum\Endpoints;
use App\Voluum\Influencer;
use App\Voluum\Offer;
use App\Models\InfluencerContract;

class Campaign extends Voluum{

    public function createCampaign($campaign_id){
        $campaign = InfluencerContract::whereHas('ads')->whereHas('influencers')->find($campaign_id);

        if(!$campaign){
            $error = [
                'error' => "$campaign_id Not found",
                'status' => false
            ];
            $this->log($error);
            return response()->json($error, 404);
        }

        if($campaign->influencers->voluum_id == null){
            $influencer = new Influencer;
            $influencer->addInfluencer($campaign->influencers->id);
            $campaign = InfluencerContract::find($campaign->id);
        }

        if($campaign->ads->voluum_id == null){
            $offer = new Offer;
            $offer->createOffer($campaign->ads->id);
            $campaign = InfluencerContract::find($campaign->id);
        }   

        $checkCampaign = $this->checkCampaignExists($campaign);
        if($checkCampaign){
            $voluumCampaign = $this->updateCampaign($campaign,$checkCampaign['rows'][0]['campaignId']);
        }else{
            $voluumCampaign = $this->insertCampaign($campaign);
        }

        if($voluumCampaign['status']){
            $data = [
                'message' => "$campaign_id Campaign added Successfully",
                'status' => true,
                'data' => $voluumCampaign
            ];
            $this->log($data);
            return response()->json($data, 200);
        }

        $error = [
            'error' => "$campaign_id Not set",
            'status' => false,
            'data' => $voluumCampaign
        ];
        $this->log($error);
        return response()->json($error, 400);

    }

    private function updateCampaign($campaign,$campaignId){
        
        $data = $this->getCampaignParams($campaign,$campaignId);
        $response = $this->put(Endpoints::updateCampaignEndpoint($campaignId),$data);
        if($response && isset($response['id'])){
            $campaign->update([
                'voluum_id' => $response['id'],
                'campaign_url' => $response['url']
            ]);
            return ['status' => true,'data' => $response];
        }

        return ['status' => false,'data' => $response];
    }

    private function insertCampaign($campaign){
        $data = $this->getCampaignParams($campaign);
    
        $response = $this->post(Endpoints::campaignEndpoint(),$data);
        
        if($response && isset($response['id'])){
            $campaign->update([
                'voluum_id' => $response['id'],
                'campaign_url' => $response['url']
            ]);
            return ['status' => true,'data' => $response];
        }
        return ['status' => false,'data' => $response];
    }

    private function getCampaignParams($campaign,$campaignId = false){

        $link = explode('?',trim($campaign->ads->store_link,'/'));

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
            "namePostfix"       => "campaign-" . $campaign->ad_id . "-" . $campaign->influencer_id,
            "url"               => "",
            "impressionUrl"     => "",
            "basic"             => true,
            "costModel"         => [
                "type"                  => "NOT_TRACKED",
                "trafficLossEnabled"    => false,
                "trafficLossRatio"      => null,
            ],
            "trafficSource"        => [
                "id"                    => $campaign->influencers->voluum_id,
                "name"                  => $campaign->influencers->nick_name,
                "impressionSpecific"    => false,
                "externalIds"           => [],
                "currencyCode"          => "USD",
                "customVariables"       =>  [
                    [
                        "index"             => 1,
                        "name"              => "Almuaathir ID",
                        "parameter"         => "almuaathir_id_" . $campaign->influencers->id,
                        "placeholder"       => $campaign->influencers->id,
                        "trackedInReports"  => true
                    ]
                ],
                "workspace"             => null,
                "directTracking"        => false,
                "skipSendingPostback"   => true,
            ],
            "redirectTarget"        => [
                "inlineFlow"    => [
                    "id" => "9e895b51-fc45-4620-0aed-d5308ca843ec",
                    "name" => "Global - inline path",
                    "defaultPaths" => [
                        [
                            "id"            => "f643156b-1b4b-49ce-89c9-3280d6eff000",
                            "name"          => "New path",
                            "active"        => true,
                            "weight"        => 100,
                            "destination"   => "DIRECT_LINKING",
                            "autoOptimized" => false,
                            "offers"    => [
                                [
                                    "offer" => [
                                        "id"            => $campaign->ads->voluum_id,
                                        "namePostfix"   => $campaign->ads->store . "-offer-" . $campaign->ads->id,
                                        "url"           => $url,
                                        "affiliateNetwork" => [
                                            "id"                                => "00000000-0000-0000-0000-000000000000",
                                            "name"                              => "None",
                                            "appendClickIdToOfferUrl"           => false,
                                            "duplicatedPostbackIsUpsell"        => false,
                                            "whitelistConfiguration"            => [
                                                "onlyWhitelistedPostbackIps"    => false
                                            ],
                                            "workspace"                         => null,
                                            "currencyCode"                      => "USD",
                                            "conversionTrackingMethod"          => "S2S_POSTBACK_URL"
                                        ],
                                        "country" => [
                                            "code"  => "global",
                                            "name"  => "Global",
                                        ],
                                        "tags"      => [str_replace(' ','_',$campaign->ads->categories->getTranslation('name','en'))],
                                        "conversionTrackingMethod" => "S2S_POSTBACK_URL",
                                    ],
                                    "weight" => 100
                                ]
                                
                            ],
                            "offerRedirectMode"         => "REGULAR",
                            "realtimeRoutingApiState"   => "DISABLED",
                            "offersDisplaySortOrder"    => null,
                            "landersDisplaySortOrder"   => null,
                            "listicle"                  => false
                        ]
                    ],
                    "conditionalPathsGroups"        => [],
                    "defaultOfferRedirectMode"      => "REGULAR",
                    "realtimeRoutingApi"            => "DISABLED",
                    "workspace"     => [
                        "id"    => "5270d276-5604-43ae-a7a7-a417e03d6251"
                    ],
                    "defaultPathsSmartRotation"     => false
                ]
            ],
            "tags"      => [],
            "workspace" => [
                "id" => "5270d276-5604-43ae-a7a7-a417e03d6251"
            ],
            "directTracking" => false
        ];

        if($campaignId){
            $data['id'] = $campaignId;
        }

        return $data;
    }

    private function checkCampaignExists($campaign){
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