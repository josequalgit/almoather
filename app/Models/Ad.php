<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SocialMedia;
use DB;
class Ad extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,SoftDeletes;

    protected $fillable = [
        'type',
        'store',
        'ad_type',
        'marouf_num',
        'store_link',
        'cr_num',
        'about',
        'scenario',
        'budget',
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
        'tax_value'
    ];

    protected $append = 
    [
        'videos',
        'image',
        'document',
        'logo'
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
        return $this->belongsTo(Area::class,'area_id');
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

    // public function contacts()
    // {
    //     return $this->hasOne(Contract::class,'ad_id');
    // }
    public function contacts()
    {
        return $this->hasOne(CampaignContract::class,'ad_id');
    }

    // public function campaignContract()
    // {
    //     return $this->hasOne(CampaignContract::class,'ad_id');
    // }

    public function customerAdRateings()
    {
        return $this->hasMany(CustomerAdRating::class,'ad_id');
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
    public function getDocumentAttribute() {
        $mediaItems = $this->getMedia('commercial_docs');
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
    public function getLogoAttribute() {
        $mediaItems = $this->getMedia('logos');
        $publicFullUrl = null;
        if(count($mediaItems) > 0)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
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
        
       return Contract::where(['influencer_id'=>$inf_id])
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
   

}
