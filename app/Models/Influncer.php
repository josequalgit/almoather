<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use App\Models\Contract;
use App\Models\InfluencerContract;
use URL;

class Influncer extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,HasTranslations;

    public $translatable = ['full_name'];



    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
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
        // 'birthday',
        'id_number',
        'phone',
        'ratting',
        'ad_with_vat',
        'ad_onsite_price_with_vat',
        // 'address',
        'commercial_registration_no',
        'tax_registration_number',
        'rep_full_name',
        'rep_phone_number',
        'rep_city',
        'rep_area',
        'rep_street',
        'milestone',
        'street',
        'neighborhood',
        'rejected_note',
        'bank_id',
        'bank_account_name',
        'subscribers',
        'subscribers_update',
    ];

    protected $append = [
        'gallery',
        'verify',
        'commercialFiles',
        'taxFiles',
        'full_name'
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

    // public function contracts()
    // {
    //     return $this->hasMany(Contract::class,'influencer_id');
    // }
    public function contracts()
    {
        return $this->hasMany(InfluencerContract::class,'influencer_id');
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

    public function getGalleryAttribute(Type $var = null)
    {
        $mediaItems = $this->getMedia('gallery');
        $medias = [];
        if(count($mediaItems) > 0){
            foreach($mediaItems as $item){
                $videoThumbnail = '';
                if(explode('/',$item->mime_type)[0] == 'video'){
                    if(file_exists(storage_path('app/public/' . $item->id . '/thumbnail.png'))){
                        $videoThumbnail = URL::to('/storage/' . $item->id . '/thumbnail.png');
                    }else{
                        $videoThumbnail = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIbS95_HsNHOxW05lRFaEOx52YxA2aCxP1TXwDCjwyjB8bBb4mqXf3edVSKdB2KvDsHC4&usqp=CAU';
                    }
                }
                $medias[] = [
                    'id' => $item->id,
                    'url' => $item->getFullUrl(),
                    'mime_type' => explode('/',$item->mime_type)[0],
                    'video_thumb' => $videoThumbnail
                ];
            }
        } 
        return $medias;
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
        $contract = InfluencerContract::where(['influencer_id'=>$this->id])
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

    public function getCommercialFilesAttribute()
    {
        $mediaItems = $this->getMedia('cr_file');
        if(count($mediaItems) > 0)
        {
            $mediaItems = $this->getMedia('cr_file')[0];
            $publicFullUrl = null;
            $array_of_links = [];
           
            return [
                'id'=>$mediaItems->id,
                'url'=>$mediaItems->getFullUrl()
            ];
        }
        else
        {
            return null;
        }
    }

    public function getTaxFilesAttribute()
    {
        $mediaItems = $this->getMedia('tax_registration_number_file');
        if(count($mediaItems) > 0)
        {
            $mediaItems = $this->getMedia('tax_registration_number_file')[0];
            $publicFullUrl = null;
            $array_of_links = [];
           
            return [
                'id'=>$mediaItems->id,
                'url'=>$mediaItems->getFullUrl()
            ];
        }
        else
        {
            return null;
        }
       
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }


}
