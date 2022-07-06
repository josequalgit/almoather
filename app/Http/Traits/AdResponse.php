<?php

namespace App\Http\Traits;

use App\Models\CampaignContract;
use App\Models\Contract;
use App\Models\InfluencerContract;
use Auth;
use Carbon\Carbon;
use Mpdf\Mpdf;

trait AdResponse
{

    private $trans_dir = 'messages.api.';

    public function adResponse($ad)
    {
        $info = $ad->influncers ? $ad->influncers()->get()->map(function ($item) {
            return $this->userDataResponse([], null, $item->users->id);
        }) : null;

        $matches = $ad->matches()->where('chosen', 1)->where('status','!=','deleted')->get();
        $hasInfluencerError = false;
        foreach($matches as $match){
            if(!$match->contract || !$match->contract->date || !$match->contract->scenario){
                $hasInfluencerError = true;
                break;
            }
        }
        $admin_approved_influencers = $ad->admin_approved_influencers == 1 && !$hasInfluencerError;

        $date = $ad->created_at->format('d/m/Y');
        $start_date = null;
        $end_date = null;
        
        if($ad->InfluencerContract){
            $contractData = $ad->InfluencerContract()->orderBy('date','asc')->first();
            if($contractData && $contractData->date){
                $start_date = $contractData->date->format('d/m/Y');
            }

            $contractData = $ad->InfluencerContract()->orderBy('date','desc')->first();
            if($contractData && $contractData->date){
                $end_date = $contractData->date->format('d/m/Y');
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
            'relation' => $ad->relations ? [
                'id' => $ad->relations->id,
                'name' => $ad->relations->title,
            ] : null,
            'category' => $ad->categories ? $ad->categories->name : null,
            'scenario' => $ad->scenario,
            'videos' => $ad->videos,
            'influencer' => $info ? $info : null,
            'budget' => $ad->budget,
            'format_budget' => $this->formateMoneyNumber($ad->budget),
            'date' => !$start_date || !$end_date ?  $date : null,
            'start_date' => $start_date && $end_date ?  $start_date : null,
            'end_date' => $start_date && $end_date ?  $end_date : null,
            'type' => trans($this->trans_dir . $ad->ad_type),
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
            'is_onSite' => trans($this->trans_dir . $ad->ad_type),
            'tax_value' => $ad->tax_value,
            'reject_note' => $ad->reject_note,
            'admin_approved_influencers' => $admin_approved_influencers ? true : false
        ];

        $contractStatuses = ['fullpayment','progress','complete'];
        $basicResponse['executionDate'] = null;
        $basicResponse['camp_link'] = null;
        if (in_array($ad->status,$contractStatuses) && Auth::guard('api')->user()->customers) {
            $basicResponse['contract'] = route('contractApi',$ad->id);
        }

        if (Auth::guard('api')->user()->influncers) {
            $contractData = $ad->InfluencerContract()->where('influencer_id',Auth::guard('api')->user()->influncers->id)->first();
            $basicResponse['contract'] = route('InfluencerContractApi',[$ad,Auth::guard('api')->user()->influncers->id]);
            $basicResponse['contractId'] = $contractData->id;
            if($contractData->rejectNote) $basicResponse['rejectNote'] = $contractData->rejectNote;
            $basicResponse['contractId'] = $contractData->id;
            
            $basicResponse['executionDate'] = $contractData && $contractData->date ? $contractData->date->format('d/m/Y') : trans($this->trans_dir . 'date_not_set');
            
            $basicResponse['status'] = $this->getStatusForInf($ad);
            if($basicResponse['status'] == 'Progress'){
                $basicResponse['camp_link'] = 'https://josequal.com';
            }

            $basicResponse['date'] = $contractData && $contractData->created_at ?  $contractData->created_at->diffForHumans() : '';

            $basicResponse['showExecution'] = $contractData && $contractData->date && !$contractData->date->gt(Carbon::now()) ? true : false;
        }

        //Return Matches if the status is Full payment / Choosing influencer / Progress
        if (Auth::guard('api')->user()->customers && $ad->status !== 'pending' && $ad->status !== 'approve' && $ad->status !== 'prepay' && $ad->status !== 'rejected') {
            $basicResponse['matches'] = $ad->matches()->where('status', '!=', 'deleted')->where('chosen', 1)->get()->map(function ($item) use($ad) {
                $contract = InfluencerContract::where('influencer_id', $item->influencer_id)->where('ad_id',$ad->id)->first();

                $influencerPrice = $ad->onSite ? $item->ad_onsite_price_with_vat : $item->influencers->ad_onsite_price_with_vat;

                $status = null;

                $status = trans($this->trans_dir . 'Not Join Yet');
                $showChat = false; 
                if ($contract && $contract->is_accepted == 1) {
                    $status = trans($this->trans_dir . 'Joined');
                    $showChat = true;
                } 

                $response = [
                    'id' => $item->influencers->id,
                    'image' => $item->influencers->users->infulncerImage,
                    'name' => $item->influencers->nick_name,
                    'match' => $item->match,
                    'status' => $status,
                    'showChat' => $showChat,
                    'gender'    => trans($this->trans_dir.$item->influencers->gender),
                    'budget'    => number_format($influencerPrice),
                ];

                $isProfitable = $ad->campaignGoals->profitable;

                $response['ROAS'] = null;
                $response['engagement_rate'] = null;
                $response['AOAF'] = null;

                if($isProfitable){
                    $response['ROAS'] = $item->match . '%';
                }else{
                    $response['engagement_rate'] = $item->match . '%';
                    $response['AOAF'] = $item->AOAF;
                }

                $response['start_date'] = null;
                if($contract && $contract->date){
                    $response['start_date'] = $contract->date->format('d/m/Y');
                }

                return $response;
            });
        }

        if (Auth::guard('api')->user()->customers) {
            $basicResponse['status'] = $ad->status;
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

        if ($contract->status == 2 && $contract->admin_status == 1) {
            return 'Completed';
        }

        if ($contract->status == 1 && $contract->admin_status == 0) {
            return 'waiting admin approve';
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

        return null;

    }

    private function formateMoneyNumber($number)
    {
        return number_format($number, 0, '.', ',');
    }

    public function generateContractPdf($contract,$title = ''){
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
        $pdf->SetTitle($title);
        $pdf->setAutoTopMargin = 'stretch';
        $pdf->SetDisplayMode('fullpage');
        $html = view('dashboard.contract.pdf',compact('contract','title'))->render();
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->SetWatermarkImage(public_path('img/avatars/logo-almuaather-full.jpg'),0.2,array(130,130));
        $pdf->showWatermarkImage = true;
        $pdf->SetDefaultBodyCSS('background', "url('".asset('img/avatars/pdf-bg.jpg')."')");
        $pdf->SetDefaultBodyCSS('background-image-resize', 6);
        $pdf->SetDefaultBodyCSS('background-position', 'top right');
        $pdf->SetDefaultBodyCSS('background-repeat', 'no-repeat');
       

        $pdf->WriteHTML($html);

        $pdf->Output();
        
    }
}
