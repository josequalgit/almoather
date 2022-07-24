<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AddInfluencer;
use Carbon\Carbon;
use App\Models\Ad;
use App\Models\User;
use App\Models\InfluencerContract;
use App\Models\Influncer;
use App\Http\Traits\SendNotification;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Notification;

class CheckAdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:check';
    public $notification_trans_dir = 'notifications.';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the if any of the ads status should change';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    use SendNotification;

    public function handle()
    {   
        $setting = AppSetting::where('key','expired_info')->first();
        $setting = (array) json_decode($setting->value);
        
        $firstPaymentWarning = isset($setting['campaign_first_payment_reminder']) ? $setting['campaign_first_payment_reminder'] : config('global.CAMPAIGN_FIRST_PAYMENT_REMINDER');
        $firstPaymentCancel = isset($setting['campaign_first_payment_period']) ? $setting['campaign_first_payment_period'] : config('global.CAMPAIGN_FIRST_PAYMENT_PERIOD');
        
        $firstPaymentAds = Ad::where('status','approve')->get();
        
        
        foreach($firstPaymentAds as $item)
        {
            $countDiffDays = $item->status_updated_at->diffInDays(Carbon::now());
            $lastNotification = $item->last_notification_time->diffInHours(Carbon::now());
            
            if($lastNotification < 24){
                continue;
            }

            /** SEND NOTIFICATION FOR THE CUSTOMER HOW'S ADS WILL BE CANCELED SOON */
            if($firstPaymentWarning <= $countDiffDays && $firstPaymentCancel > $countDiffDays)
            {
                $title = 'campaign_expire_soon';
                $msg = 'campaign_expire_soon_msg';
                $transParams = ['ad_name' => $item->store];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];

                $this->saveAndSendNotification($info,[],$users,$item->customers->users->lang);

                $title = 'campaign_expire_soon_admin';
                $msg = 'campaign_expire_soon_admin_msg';
                $transParams = ['ad_name' => $item->store,'customer_name' => $item->customers->full_name];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin']);
                $item->last_notification_time = Carbon::now();
                $item->save();
            }
                #CHECK FOR ANY AD WAS ADDED AND WASN'T AND THE CUSTOMER DID'T PAY FOR 28 DAYS
            elseif($firstPaymentCancel <= $countDiffDays)
            {
                $title = 'campaign_expire';
                $msg = 'campaign_expire_msg';
                $transParams = ['ad_name' => $item->store];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin'],$users,$item->customers->users->lang);

                $item->status = 'rejected';
                $item->reject_note = "لقد تم رفض الحملة بسبب عدم دفع المبلغ المطلوب";
                $item->last_notification_time = Carbon::now();
                $item->save();
            }
            
        }

        $fullPaymentWarning = isset($setting['campaign_full_payment_reminder']) ? $setting['campaign_full_payment_reminder'] : config('global.CAMPAIGN_FULL_PAYMENT_REMINDER');
        $fullPaymentCancel = isset($setting['campaign_full_payment_period']) ? $setting['campaign_full_payment_period'] : config('global.CAMPAIGN_FULL_PAYMENT_PERIOD');
        
        $fullPaymentAds = Ad::where(['status' => 'choosing_influencer','admin_approved_influencers' => 1])->get();

        foreach($fullPaymentAds as $item)
        {
            $countDiffDays = $item->status_updated_at->diffInDays(Carbon::now());
            $lastNotification = $item->last_notification_time->diffInHours(Carbon::now());
            
            if($lastNotification < 24){
                continue;
            }

            /** SEND NOTIFICATION FOR THE CUSTOMER HOW'S ADS WILL BE CANCELED SOON */
            if($fullPaymentWarning <= $countDiffDays && $fullPaymentCancel > $countDiffDays)
            {
                $title = 'campaign_expire_soon';
                $msg = 'campaign_expire_soon_msg';
                $transParams = ['ad_name' => $item->store];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];

                $this->saveAndSendNotification($info,[],$users,$item->customers->users->lang);

                $title = 'campaign_expire_soon_admin';
                $msg = 'campaign_expire_soon_admin_msg';
                $transParams = ['ad_name' => $item->store,'customer_name' => $item->customers->full_name];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin']);
                $item->last_notification_time = Carbon::now();
                $item->save();
            }
                #CHECK FOR ANY AD WAS ADDED AND WASN'T AND THE CUSTOMER DID'T PAY FOR 28 DAYS
            elseif($fullPaymentCancel <= $countDiffDays)
            {
                $title = 'campaign_expire';
                $msg = 'campaign_expire_msg';
                $transParams = ['ad_name' => $item->store];
                $users = [$item->customers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin'],$users,$item->customers->users->lang);

                $item->status = 'cancelled';
                $item->reject_note = "لقد تم الغاء الحملة بسبب عدم دفع المبلغ المطلوب";
                $item->last_notification_time = Carbon::now();
                $item->save();
            }               
        }

        // check if there is no response for the contracts
        $contracts = InfluencerContract::whereHas('ads',function($query){
            return $query->whereIn('status',['fullpayment','active','progress','complete']);
        })->where('is_accepted',0)->get();

        $contractPeriod = isset($setting['campaign_influencer_contract_cancelled']) ? $setting['campaign_influencer_contract_cancelled'] : config('global.CAMPAIGN_INFLUENCER_CONTRACT_CANCELLED');

        
        foreach ($contracts as $item) {
            $countDiffDays = $item->contract_send_at->diffInDays(Carbon::now());
            $lastNotification = $item->last_notification_time->diffInHours(Carbon::now());
            
            if($lastNotification < 24){
                continue;
            }

            if($contractPeriod > $countDiffDays){
                $title = 'contract_expire_soon';
                $msg = 'contract_expire_soon_msg';
                $transParams = ['ad_name' => $item->ads->store];
                $users = [$item->influencers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,[],$users,$item->influencers->users->lang);

                $title = 'contract_expire_admin_soon';
                $msg = 'contract_expire_admin_soon_msg';
                $transParams = ['ad_name' => $item->ads->store,'inf_name' => $item->influencers->full_name];
                
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin']);

                $item->last_notification_time = Carbon::now();
                $item->save();
            }else{
                $title = 'contract_expired';
                $msg = 'contract_expired_msg';
                $transParams = ['ad_name' => $item->ads->store];
                $users = [$item->influencers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,[],$users,$item->influencers->users->lang);

                $title = 'contract_expired_admin';
                $msg = 'contract_expired_admin_msg';
                $transParams = ['ad_name' => $item->ads->store,'inf_name' => $item->influencers->full_name];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin']);

                $item->last_notification_time = Carbon::now();
                $item->is_accepted = 2;
                $item->rejectNote = 'لم بتم الرد على العقد بالوقت المطلوب';
                $item->save();
            }
        }


        $contracts = InfluencerContract::where('is_accepted',1)->where('status',0)->get();
        foreach ($contracts as $item) {
            $countDiffHours = $item->date->diffInHours(Carbon::now());
            $lastNotification = $item->last_notification_time->diffInHours(Carbon::now());
            
            if($lastNotification < 24){
                continue;
            }


            if($countDiffHours < 48 && $item->date->greaterThan(Carbon::now())){
                $title = 'campaign_execute_reminder';
                $msg = 'campaign_execute_reminder_msg';
                $transParams = ['ad_name' => $item->ads->store];
                $users = [$item->influencers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,[],$users,$item->influencers->users->lang);
                $item->last_notification_time = Carbon::now();
                $item->save();
            }else if($item->date->lessThan(Carbon::now())){
                $title = 'campaign_execute_reminder';
                $msg = 'campaign_execute_now_reminder_msg';
                $transParams = ['ad_name' => $item->ads->store];
                $users = [$item->influencers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,[],$users,$item->influencers->users->lang);

                $title = 'campaign_execute_reminder';
                $msg = 'campaign_execute_now_admin_msg';
                $transParams = ['ad_name' => $item->ads->store,'inf_name' => $item->influencers->full_name,'exec_date' => $item->date->format('d/m/Y')];
                $users = [$item->influencers->users->id];
                $info =[
                    'msg'           => $msg,
                    'title'         => $title,
                    'id'            => $item->ads->id,
                    'type'          => 'Ad',
                    'params'        => $transParams
                ];
                
                $this->saveAndSendNotification($info,['Business Manager','superAdmin']);
                $item->last_notification_time = Carbon::now();
                $item->save();
            }
        }
    }



    private function get_ads_according_to_amount_of_days($amountOfDaysBehind ,$status , $col = null)
    {
        $from = Carbon::now()->subDays($amountOfDaysBehind)->startOfDay()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
       return Ad::whereBetween($col ?? 'updated_at', [$from,$to])
        ->where('status',$status)
        ->get();
    }
}
