<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SocialMedia;
use App\Models\InfluencerContract;
use DB;
use URL;

class Ad extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,SoftDeletes;

    protected $fillable = [
        'voluum_id',
        'type',
        'store',
        'ad_type',
        'marouf_num',
        'store_link',
        'cr_num',
        'about',
        'scenario',
        'budget',
        'price_to_pay',
        'discount_code',
        'social_media_id',
        'country_id',
        'city_id',
        'area_id',
        'customer_id',
        'category_id',
        'status',
        'influncer_id',
        'reject_note',
        'expense_type',
        'is_verified',
        'campaign_goals_id',
        'relation',
        'is_added_tax',
        'is_vat',
        'about_product',
        'tax_value',
        'eng_number',
        'admin_approved_influencers',
        'relation_id',
        'status_updated_at',
        'last_notification_time',
    ];

    protected $append = 
    [
        'videos',
        'image',
        'document',
        'crImage',
        'logo',
        'adBudgetWithVat','location'
    ];

    protected $casts = [
        'last_notification_time' => 'datetime:Y-m-d',
        'status_updated_at' => 'datetime:Y-m-d'
     ];

    public function socialMedias()
    {
        return $this->belongsToMany(SocialMedia::class,'social_media_id');
    }
	

    public function socialMediasAccount()
    {
        return $this->belongsToMany(SocialMedia::class,'prefered_media_id','ad_id','media_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function areas()
    {
        return $this->belongsTo(Region::class,'area_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function influncers()
    {
        return $this->belongsTo(Influncer::class,'influncer_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function contacts()
    {
        return $this->hasOne(CampaignContract::class,'ad_id');
    }

    public function customerAdRateings()
    {
        return $this->hasMany(CustomerAdRating::class,'ad_id');
    }

    public function InfluencerContract()
    {
        return $this->hasMany(InfluencerContract::class,'ad_id');
    }

    public function influencerRatting()
    {
        return $this->hasMany(InfluencerRateing::class,'ad_id');
    }

    public function marketingAdRatings()
    {
        return $this->hasMany(MarketingAdRating::class,'ad_id');
    }

    public function adSuccess()
    {
        return $this->hasMany(AdSuccess::class,'ad_id');
    }

    public function campaignGoals()
    {
        return $this->belongsTo(CampaignGoal::class,'campaign_goals_id');
    }

    public function matches()
    {
        return $this->hasMany(AdsInfluencerMatch::class,'ad_id');
    }

    public function storeLocations()
    {
        return $this->hasMany(StoreLocation::class,'ad_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'ad_id');
    }

    public function relations()
    {
        return $this->belongsTo(Relation::class,'relation_id');
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('adImage');
        $publicFullUrl = [];
        if(count($mediaItems) > 0)
        {
			foreach($mediaItems as $item)
			{
                $obj = (object)[
                    'id'=>$item->id,
                    'url'=>$item->getFullUrl()
                ];
				// $publicFullUrl = $item->getFullUrl();
				array_push($publicFullUrl,$obj);
			}
		}
        return $publicFullUrl;
   }
    public function getVideosAttribute() {
        $mediaItems = $this->getMedia('adVideos');
        $publicFullUrl = [];
        if(count($mediaItems) > 0)
        {
			foreach($mediaItems as $item)
			{
                if(file_exists(storage_path('app/public/' . $item->id . '/thumbnail.png'))){
                    $videoThumbnail = URL::to('/storage/' . $item->id . '/thumbnail.png');
                }else{
                    $videoThumbnail = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIbS95_HsNHOxW05lRFaEOx52YxA2aCxP1TXwDCjwyjB8bBb4mqXf3edVSKdB2KvDsHC4&usqp=CAU';
                }
                $obj = (object)[
                    'id' => $item->id,
                    'thumbnail' => $videoThumbnail,
                    'url' => $item->getFullUrl(),
                    'path' => $item->getPath()
                ];
				// $publicFullUrl = $item->getFullUrl();
				array_push($publicFullUrl,$obj);
			}
           
        }
        return $publicFullUrl;
   }
    public function getDocumentAttribute() {
        $mediaItems = $this->getMedia('commercial_docs');
        $publicFullUrl = [];
        $obj = [];
        if(count($mediaItems) > 0)
        {
			foreach($mediaItems as $item)
			{
                $obj = (object)[
                    'id'=>$item->id,
                    'url'=>$item->getFullUrl()
                ];
				// $publicFullUrl = $item->getFullUrl();
				array_push($publicFullUrl,$obj);
			}
           
        }
     //   return $publicFullUrl;
        return $publicFullUrl;
   }
    public function getCrImageAttribute() {
        $mediaItems = $this->getMedia('document');
        $obj = [];
        $array = [];
        if(count($mediaItems) > 0)
        {
			
                $obj = (object)[
                    'id'=>$mediaItems[0]->id,
                    'url'=>$mediaItems[0]->getFullUrl()
                ];
                array_push($array,$obj);
				// $publicFullUrl = $item->getFullUrl();
			
			
           
        }
        return $obj;
   }
    public function getLogoAttribute() {
        $mediaItems = $this->getMedia('logos')->first();
        if($mediaItems)
        {
            return [
                'id'=> $mediaItems->id,
                'url'=> $mediaItems->getFullUrl()
            ];
        }
        return [
            'id'=> 0,
            'url'=>'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg'
        ];
   }
   public function checkIfAccepted($inf_id)
   {
       /**
        *  0 => is rejected
        *  1 => is accepted
        *  2 => no Contract avalibale
        */
        
       $contract = Contract::where(['influencer_id'=>$inf_id])
       ->where(['ad_id'=>$this->id])
       ->first();
       
       if($contract)
       {
           if($contract->is_accepted)
           {
               return 1;
           }
           else
           {
               return 0;
           }
       }
       else
       {
           return 2;
       }
   }

  

   public function getInfAdContract($inf_id)
   {
       return InfluencerContract::where(['influencer_id'=>$inf_id])
        ->where(['ad_id'=>$this->id])
        ->first();
   }


    public function getSocialMediaLinks()
    {
        $socialMedia = DB::table('social_media_id')->where('ad_id',$this->id)->get();
        $data = [];
        foreach ($socialMedia as $key => $value) {
            $obj = (object) [];
            $t = SocialMedia::find($value->social_media_id);
            $obj->image = $t->image;
            $obj->title = $t->title;
            $obj->link = $value->link;
            array_push($data,$obj);
        }
      //  dd($data);
        return $data;

    }

    public function is_all_accepted()
    {
       $data =  $this->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item){
            $contract = InfluencerContract::where('influencer_id',$item->influencer_id)->first();
            
                if(isset($contract)&&$contract->is_accepted == 2)
                {
                    return false ;
                }
                else if(isset($contract)&&$contract->is_accepted == 1)
                {
                    if($contract->status == 1&&$contract->admin_status == 1)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
        })
        ->reject(function ($value) {
            return $value === true;
        });
       
        return (count($data) > 0) ? false : true;
    }



    public function socialMediaWithAccount()
    {
       return DB::table('social_media_id')->where([
            'ad_id'=>$this->id,
         ])->get()->map(function($item){
             return [
                 'id'=>$item->id,
                 'link'=>$item->link,
             ];
         });
    }

    public function getStoreLinkAttribute()
    {
        return strpos($this->attributes['store_link'], "http") !== false ? $this->attributes['store_link'] : 'https://' . $this->attributes['store_link'];
    }

    public function checkIfNumberExist()
    {
       $isCrNumber =  $this->where('id','!=',$this->id)->where('cr_num','!=',null)->where('cr_num',$this->cr_num)->first();
       $isMarouf_num =  $this->where('id','!=',$this->id)->where('cr_num','!=',null)->where('marouf_num',$this->marouf_num)->first();
       if($isCrNumber) return 'This certificate number was registered before';
       if($isMarouf_num) return 'This marouf number was registered before';
       return null;
    }

    public function AdSocialMediaAccounts()
    {
        return $this->belongsToMany(SocialMedia::class,'social_media_id','ad_id','social_media_id')->withPivot('link');
    }

    function getAdBudgetWithVatAttribute(){
        $budget = $this->price_to_pay;
        $tax = AppSetting::where('key', 'tax')->first();
        if($tax){
            $tax = $tax->value;
            $budget = $this->price_to_pay + ($this->price_to_pay * ($tax / 100));
        }
        return $budget;
    }

    function getLocationAttribute(){
        $location = '';
        if($this->countries){
            $location .= $this->countries->name . ', ';
        } 
        if($this->areas){
            $location .= $this->areas->name . ', ';
        } 
        if($this->cities){
            $location .= $this->cities->name;
        } 

        return trim($location,', ');
    }
   

}
