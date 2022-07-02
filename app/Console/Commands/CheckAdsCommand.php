<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AddInfluencer;
use Carbon\Carbon;
use App\Models\Ad;
use App\Models\User;
use App\Models\Contract;
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
            $warningDaysPeriod = config('global.WARNING_DAYS_PERIOD');
            $canceledDaysPeriod = config('global.CANCELED_DAYS_PERIOD');
            $resetDaysPeriod = config('global.CANCELED_DAYS_PERIOD');
            if($setting)
            {
                $ser = json_decode($setting->value);
                // $warningDaysPeriod = $ser['warning_days_period'];
                // $canceledDaysPeriod = $ser['canceled_days_period'];
            }
            $ads = Ad::get();
            $canceledDaysPeriod = $warningDaysPeriod;
            $warningDaysPeriod = $warningDaysPeriod;
            $cDate = Carbon::parse()->now();

            foreach($ads as $item)
            {
                $countDiffDays = $item->updated_at->diffInDays($cDate);

                /** SEND NOTIFICATION FOR THE CUSTOMER HOW'S ADS WILL BE CANCELED SOON */
                if($countDiffDays == $warningDaysPeriod)
                {
                    $info =[
                        'en'=>[
                            'msg'=>'Please add a payment for "'."$item->store".'" ad or it will be canceled',
                            'type'=>'Ad',
                            'id'=>$item->id
                        ],
                        'ar'=>[
                            'msg'=>'الرجاء اضافة طريق الدفع "'."$item->store".'" لعدم الالغاء',
                            'type'=>'Ad',
                            'id'=>$item->id
                        ],
                    ];

                    $adminMessage =[
                        'en'=>[
                            'msg'=>'Notification was sent to "'.$item->customers->first_name.' '.$item->customers->last_name.'" about canceling "'.$item->store.'" campaign',
                            'type'=>'Ad',
                            'id'=>$item->id
                        ],
                        'ar'=>[
                            'msg'=>'تم ارسال الاشعار الى "'.$item->customers->first_name.' '.$item->customers->last_name.'" حول الغاء الحملة "'.$item->store.'"',
                            'type'=>'Ad',
                            'id'=>$item->id
                        ]
                    ];
                    #SEND NOTIFICATION TO CUSTOMER ABOUT THE AD
                    $sendTo = User::where('id',[$item->customers->users->id])->get();
                    $lang = $item->customers->users->lang;
                    $data = [
                        "title" => "Ads " . $ad->store . " Reminder",
                        "body" => $info[$lang],
                        "type" => 'Ad',
                        'target_id' =>$ad->id            
                    ];
                    $tokens = [$ad->customers->users->fcm_token];

                    $this->sendNotifications($tokens,$data);
                    Notification::send($sendTo, new AddInfluencer($adminMessage[$lang??'en']));    
                    
                    #SEND NOTIFICATION TO ADMIN ABOUT THE AD
                    $sendTo = User::where('id',[1])->get();
                    Notification::send($sendTo, new AddInfluencer($adminMessage[$lang??'en']));    
                }
                 #CHECK FOR ANY AD WAS ADDED AND WASN'T AND THE CUSTOMER DID'T PAY FOR 28 DAYS
                elseif($countDiffDays == $canceledDaysPeriod || $countDiffDays > $canceledDaysPeriod)
                {
                    $item->status = 'cancelled';
                    $item->save();
                }
               
            }

            // check if there is no response for the contracts
            $contracts = Contract::get();
          
            foreach ($contracts as $item) {
                if($item->ads)
                {
                    $adminMessage =[
                        'en'=>[
                            'msg'=>'Please add response to "'.$item->ads->store.'"ad contract"'
                        ],
                        'ar'=>[
                            'msg'=>'الرجاء الرد على عقد "'.$item->ads->store.'"'
                        ]
                        ];

                }

                
                #SEND NOTIFICATION TO INFLUENCER ABOUT THE AD
                $remind_about_ad_date = [];
                if($item->influencers)
                {
                    $before2DaysDate = date("Y-m-d", strtotime("-2 day"));
                    $before1DaysDate = date("Y-m-d", strtotime("-1 day"));
                    $beforeTodayDate = date("Y-m-d");
                    $date = $item->date;
                    if($before2DaysDate == $date)
                    {
                        $sendTo = User::find($item->influencers->users->id);
                        $lang = $item->influencers->users->lang;
                        Notification::send($sendTo, new AddInfluencer($adminMessage[$lang??'en']));
                    }
                    if($before1DaysDate == $date)
                    {
                        $message_body = [
                            "title" => trans($this->notification_trans_dir.'ad_reminder_before_one_day_title'),
                            "body" => trans($this->notification_trans_dir.'ad_reminder_before_one_day',['ad_name'=>$item->ads->store]),
                            "type" => 'influencers',
                            'target_id' =>$item->ads->id
                        ];
                        $this->sendNotifications([$item->influencers->users->fcm_token],$message_body);

                    }
                    if($beforeTodayDate == $date)
                    {
                        $message_body = [
                            "title" => trans($this->notification_trans_dir.'ad_reminder_before_one_day_title'),
                            "body" => trans($this->notification_trans_dir.'ad_reminder_for_today',['ad_name'=>$item->ads->store]),
                            "type" => 'influencers',
                            'target_id' =>$item->ads->id
                        ];
                        $this->sendNotifications([$item->influencers->users->fcm_token],$message_body);

                    }
                }
            }

            // CHECK WHEN THE LAST TIME THE USER UPDATED HE'S SUBSCRIBERS
            $influencers = Influncer::get();
            $checkSubscription =[
                'en'=>[
                    'msg'=>'Please Update Your Subscription Number'
                ],
                'ar'=>[
                    'msg'=>'الرجاء تحديث عدد متابعينك'
                ]
                ];
            $checkSubscriptionTitle =[
                'en'=>[
                    'msg'=>'Update Subscribers!'
                ],
                'ar'=>[
                    'msg'=>'تحديث المشتركين'
                ]
                ];

              
                $tokens = [];
                $tokens_for_reminder = [];
            foreach ($influencers as $value) 
            {
                $countDiffDays = Carbon::parse($value->subscribers_update)->diffInDays($cDate);

                if($countDiffDays >= $canceledDaysPeriod)
                {
                    if($countDiffDays >= $resetDaysPeriod)
                    {
                        $influencers->update([
                            'subscribers'=>50000,
                            'subscribers_update'=>Carbon::parse()->now()
                        ]);
                        $message_body_for_resting_subscribers = [
                            "title" => trans($this->notification_trans_dir,'ad_influencer_before_one_day_title'),
                            "body" => trans($this->notification_trans_dir,'influencer_reset_message'),
                            "type" => 'influencers',
                            'target_id' =>$value->users->id
                        ];
                        $this->sendNotifications([$value->users->fcm_token],$message_body_for_resting_subscribers);

                    }
                    $message_body = [
                        "title" => $checkSubscriptionTitle[$lang??'en'],
                        "body" => $checkSubscription[$lang??'en'],
                        "type" => 'influencers',
                        'target_id' =>$value->users->id
                    ];
                    $sendTo = User::find($value->users->id);
                    $lang = $item->customers->users->lang;
                   // array_push($tokens,$sendTo->users->fcm_token);
                    $this->sendNotifications([$sendTo->users->fcm_token],$message_body);
                    Notification::send($sendTo, new AddInfluencer($checkSubscription[$lang??'en']));    
                }

                #INFLUENCERS REMINDER FOR THE AD DATE 
                foreach ($value->contracts as $key => $value) {

                    $message_body_for_reminder = [
                        "title" => trans($this->notification_trans_dir.'influencers_ad_reminder_msg',['ad_name'=>$value->ads->store]),
                        "body" => $checkSubscription[$lang??'en'],
                        "type" => 'influencers',
                        'target_id' =>$value->influencers->users->id
                    ];

                    array_push($tokens_for_reminder,$value->influencers->users->fcm_token);
                    $this->sendNotifications([$value->influencers->users->fcm_token],$message_body_for_reminder);
                }


                /** UPDATE SUBSCRIPTION REMINDER */
               

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
