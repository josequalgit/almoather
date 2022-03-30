<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AddInfluencer;
use Carbon\Carbon;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class CheckAdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:check';

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
    public function handle()
    {   
            $ads = Ad::get();
            $canceledDaysPeriod = config('global.CANCELED_DAYS_PERIOD');
            $warningDaysPeriod = config('global.WARNING_DAYS_PERIOD');
           
            foreach($ads as $item)
            {
                $cDate = Carbon::parse()->now();
                $countDiffDays = $item->updated_at->diffInDays($cDate);

                /** SEND NOTIFICATION FOR THE CUSTOMER HOW'S ADS WILL BE CANCELED SOON */
                if($countDiffDays == $warningDaysPeriod)
                {
                    $info =[
                        'en'=>[
                            'msg'=>'Please add a payment for "'."$item->store".'" ad or it will be canceled'
                        ],
                        'ar'=>[
                            'msg'=>'الرجاء اضافة طريق الدفع "'."$item->store".'" لعدم الالغاء'
                        ],
                    ];

                    $adminMessage =[
                        'en'=>[
                            'msg'=>'Notification was sent to "'.$item->customers->first_name.' '.$item->customers->last_name.'" about canceling "'.$item->store.'" ad'
                        ],
                        'ar'=>[
                            'msg'=>'تم ارسال الاشعار الى "'.$item->customers->first_name.' '.$item->customers->last_name.'" حول الغاء دعاية "'.$item->store.'"'
                        ]
                    ];
                    #SEND NOTIFICATION TO CUSTOMER ABOUT THE AD
                    $sendTo = User::where('id',[$item->customers->users->id])->get();
                    $lang = $item->customers->users->lang;
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
