<?php

namespace App\Http\Traits;

use App\Models\CampaignContract;
use App\Models\Contract;
use App\Models\InfluencerContract;
use Auth;

trait AdResponse
{

    private $trans_dir = 'messages.api.';

    public function adResponse($ad)
    {
        $info = $ad->influncers ? $ad->influncers()->get()->map(function ($item) {
            return $this->userDataResponse([], null, $item->users->id);
        }) : null;

        $date = $ad->created_at->format('d/m/Y');
        if($ad->InfluencerContract){
            $date = $ad->InfluencerContract()->orderBy('date','asc')->first();
            if($date){
                $date = $date->date->format('d/m/Y');
            }
            
        }

        $basicResponse = [
            'id' => $ad->id,
            'image' => $ad->image,
            'videos' => $ad->videos,
            'cr_certificate' => $ad->document,
            'cr_image' => $ad->crImage,
            'campaign_goal' => $ad->campaignGoals ? [
                'id' => $ad->campaignGoals->id,
                'title' => $ad->campaignGoals->title,
            ] : null,
            'logo' => $ad->logo,
            'store_name' => $ad->store,
            'marouf_num' => $ad->marouf_num,
            'store_link' => $ad->store_link,
            'prefired' => $ad->socialMedias()->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'url' => $item->image,
                ];
            }),
            'media_accounts' => $ad->AdSocialMediaAccounts->map(function ($item) {

                $link = '';
                switch ($item->id) {
                    case 1:
                        $link = 'https://facebook.com/' . $item->pivot->link;
                        break;
                    case 2:
                        $link = 'https://twitter.com/' . $item->pivot->link;
                        break;
                    case 3:
                        $link = 'https://instagram.com/' . $item->pivot->link;
                        break;
                    case 4:
                        $link = 'https://snapchat.com/' . $item->pivot->link;
                        break;
                    case 5:
                        $link = 'https://youtube.com/' . $item->pivot->link;
                        break;
                    case 6:
                        $link = 'https://tiktok.com/' . $item->pivot->link;
                        break;
                }
                return [
                    'id' => $item->id,
                    'image' => $item->image,
                    'link' => $link,
                ];
            }),
            'cr_num' => $ad->cr_num,
            'about' => $ad->about,
            'relation' => $ad->relation,
            'category' => $ad->categories ? $ad->categories->name : null,
            'scenario' => $ad->scenario,
            'videos' => $ad->videos,
            'influencer' => $info ? $info : null,
            'budget' => $ad->budget,
            'format_budget' => $this->formateMoneyNumber($ad->budget),
            'date' => $date,
            'type' => $ad->ad_type,
            'price' => $ad->price,
            'website_link' => $ad->website_link,
            'about_product' => $ad->about_product,
            'country' => $ad->countries ? [
                'id' => $ad->countries->id,
                'name' => $ad->countries->name,
            ] : null,
            'city' => $ad->cities ? [
                'id' => $ad->cities->id,
                'name' => $ad->cities->name,
            ] : null,
            'area' => $ad->areas ? [
                'id' => $ad->areas->id,
                'name' => $ad->areas->name,
            ] : null,
            'location' => $ad->location,
            'customer_id' => $ad->customers->id,
            'isVat' => $ad->is_vat,
            'discount_code' => $ad->discount_code,
            'hasStore' => $ad->has_hasStore ? true : false,
            'is_onSite' => $ad->onSite ? 'Online' : 'Site',
            'tax_value' => $ad->tax_value,
            'reject_note' => $ad->reject_note,
            'admin_approved_influencers' => $ad->admin_approved_influencers ? true : false
        ];

        if ($ad->status == 'fullpayment' && Auth::guard('api')->user()->customers) {
            $contract = CampaignContract::where('ad_id',$ad->id)->first();
            $basicResponse['contract'] = $contract ? $contract->content : null;
        }
        if (Auth::guard('api')->user()->influncers) {
            $basicResponse['contract'] = InfluencerContract::select('id', 'content', 'date')->where(['influencer_id' => Auth::guard('api')->user()->influncers->id])
                ->where(['ad_id' => $ad->id])
                ->first();
        }

        //Return Matches if the status is Full payment / Choosing influencer / Progress
        if (Auth::guard('api')->user()->customers && $ad->status !== 'pending' && $ad->status !== 'approve' && $ad->status !== 'prepay' && $ad->status !== 'rejected') {
            $basicResponse['matches'] = $ad->matches()->where('status', '!=', 'deleted')->where('chosen', 1)->get()->map(function ($item) {
                $contract = InfluencerContract::where('influencer_id', $item->influencer_id)->first();

                $status = null;

                if ($contract && $contract->is_accepted == 2) {
                    $status = 'rejected';
                } else if ($contract && $contract->is_accepted == 1) {
                    if ($contract->status == 1 && $contract->admin_status == 1) {
                        $status = 'completed';
                    } else {
                        $status = 'progress';
                    }
                } else {
                    if ($contract && $contract->date) {
                        $status = 'was sent';
                    } else {
                        $status = 'not sent';
                    }
                }
                return [
                    'id' => $item->influencers->id,
                    'image' => $item->influencers->users->infulncerImage,
                    'name' => $item->influencers->nick_name,
                    'match' => $item->match,
                    'status' => $status,
                ];
            });
        }

        if (Auth::guard('api')->user()->customers) {

            $basicResponse['status'] = $ad->status;
        } else {
            $basicResponse['status'] = $this->getStatusForInf($ad);
        }
        $basicResponse['messages'] = [
            'label_text' => $this->getLabelTextResponse($ad->status),
            'button_text' => $this->getButtonTextResponse($ad->is_all_accepted() ? 'inf_list' : $ad->status),
        ];

        return $basicResponse;
    }

    private function getLabelTextResponse($status)
    {
        $array =
            [
            'pending' => trans($this->trans_dir . 'status_response_label.pending'),
            'approve' => trans($this->trans_dir . 'status_response_label.approve'),
            'choosing_influencer' => trans($this->trans_dir . 'status_response_label.choosing_influencer'),
            'prepay' => trans($this->trans_dir . 'status_response_label.choosing_influencer'),
            'fullpayment' => trans($this->trans_dir . 'status_response_label.choosing_influencer'),
        ];

        return $array[$status] ?? null;
    }

    private function getButtonTextResponse($status)
    {
        $array =
            [
            'approve' => trans($this->trans_dir . 'status_response_button_text.approve'),
            'inf_list' => trans($this->trans_dir . 'status_response_button_text.inf_list'),
            'prepay' => trans($this->trans_dir . 'status_response_button_text.inf_list'),
            'choosing_influencer' => trans($this->trans_dir . 'status_response_button_text.choosing_influencer'),
        ];

        return $array[$status] ?? null;
    }

    private function getStatusForInf($ad)
    {
        $contract = $ad->getInfAdContract(Auth::guard('api')->user()->influncers->id);
        if (!$contract) {
            return null;
        }

        if ($contract->is_accepted == 2) {
            return 'Rejected';
        }

        if ($contract->is_accepted == 1) {
            return 'Progress';
        }

        if ($contract->is_accepted == 0) {
            return 'Pending';
        }

        if ($contract->status == 1 && $contract->status == 0) {
            return 'waiting admin approve';
        }

        if ($contract->is_accepted == 2 && $contract->admin_status == 1) {
            return 'Completed';
        }

        return null;

    }

    private function formateMoneyNumber($number)
    {
        return number_format($number, 0, '.', ',');
    }
}