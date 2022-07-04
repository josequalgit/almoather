<?php
namespace App\Voluum;

class Endpoints{

    const MAIN_URL  = 'https://api.voluum.com/';
    const AUTH      = 'auth/access/session';
    const REPORT = 'report';
    const ADD_INFLUENCER = 'traffic-source';
    const CHECK_AUTH = 'auth/session/';
    const UPDATE_INFLUENCER = 'traffic-source/{uuid}';
    const OFFER = 'offer';
    const UPDATE_OFFER = 'offer/{uuid}';
    const CAMPAIGN = 'campaign';
    const UPDATE_CAMPAIGN = 'campaign/{uuid}';

    public static function authEndpoint(){
        return self::getMainUrl() . static::AUTH;
    }

    public static function reportEndpoint(){
        return self::getMainUrl() . static::REPORT;
    }

    public static function addInfluencerEndpoint(){
        return self::getMainUrl() . static::ADD_INFLUENCER;
    }

    public static function checkAuthEndpoint(){
        return self::getMainUrl() . static::CHECK_AUTH;
    }

    public static function getMainUrl(){
        return static::MAIN_URL;
    }

    public static function updateInfluencerEndpoint($uuid){
        return self::getMainUrl() . str_replace('{uuid}',$uuid,static::UPDATE_INFLUENCER);
    }

    public static function offerEndpoint(){
        return self::getMainUrl() . static::OFFER;
    }

    public static function updateOfferEndpoint($uuid){
        return self::getMainUrl() . str_replace('{uuid}',$uuid,static::UPDATE_OFFER);
    }

    public static function campaignEndpoint(){
        return self::getMainUrl() . static::CAMPAIGN;
    }

    public static function updateCampaignEndpoint($uuid){
        return self::getMainUrl() . str_replace('{uuid}',$uuid,static::UPDATE_CAMPAIGN);
    }

}