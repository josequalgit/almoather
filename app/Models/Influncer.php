<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use App\Models\Contract;

class Influncer extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,HasTranslations;

    public $translatable = ['full_name'];

    protected $fillable = [
        'full_name',
        'nick_name',
        'bank_name',
        'bank_account_number',
        'bio',
        'ads_out_country',
        'city_id',
        'country_id',
        'nationality_id',
        'influncer_category_id',
        'region_id',
        'user_id',
        'status',
        'is_vat',
        'ad_price',
        'ad_onsite_price',
        'birthday',
        'id_number',
        'phone',
        'ratting',
        'ad_with_vat',
        'ad_onsite_price_with_vat',
        'address',
        'snap_chat_views',
        'commercial_registration_no',
        'tax_registration_number',
        'rep_full_name',
        'rep_id_number_name',
        'rep_phone_number',
        'rep_email',
        'milestone',
        'street',
        'neighborhood',
        'rejected_note'
    ];

    protected $append = [
        'video',
        'verify'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function citys()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function nationalities()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }
    public function InfluncerCategories()
    {
        return $this->belongsToMany(InfluncerCategory::class);
    }
    public function socialMedias()
    {
        return $this->belongsToMany(SocialMedia::class);
    }
    public function ads()
    {
        return $this->hasMany(Ad::class,'influncer_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class,'influencer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public function socialMediaProfiles()
    {
        return $this->hasMany(SocialMediaProfile::class,'Influncer_id');
    }

    public function regions()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function ad_matches()
    {
        return $this->hasMany(AdsInfluencerMatch::class,'influencer_id');
    }

    public function getVideoAttribute(Type $var = null)
    {
        $mediaItems = $this->getMedia('videos');
        $publicFullUrl = [];
        if(count($mediaItems) > 0) $publicFullUrl = $mediaItems->getFullUrl();
        return $publicFullUrl;
    }
    public function getVerifyAttribute(Type $var = null)
    {
       
        return $this->users->email_verify_at ? true : false;
    }

    public function checkIfAccepted($ad_id)
    {
        /**
         *  0 => is rejected
         *  1 => is accepted
         *  2 => no Contract avalibale
         */
        $contract = Contract::where(['influencer_id'=>$this->id])
        ->where(['ad_id'=>$ad_id])
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
}
