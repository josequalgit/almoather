<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UpdateDataController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\PrivacyController;
use App\Http\Controllers\Api\TermsAndConditionsController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\InfluenecerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\CampaignGoalController;
use App\Http\Controllers\Api\MailController;

Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::get('changeLanguage/{lang}',[AuthController::class,'changeLang']);

    #SEND EMAIL ROUTE
    Route::controller(MailController::class)->prefix('mail')->group(function(){
        Route::post('send','basic_email');
        Route::post('checkCode','checkCode');
        Route::post('forgetPassword','forgetPassword');
    });

    #REGISTER ROUTES
    Route::controller(RegisterController::class)->prefix('register')->group(function(){
        Route::post('/influncer','registerInfluncer');
        Route::post('/customer','registerCustomer');
        Route::get('/verify','verify');
        Route::post('/customer/update/{id}',[RegisterController::class,'updateCustomer']);
        Route::post('/checkUnique','checkUniqueData');
    });

    #UPDATE ROUTES
    Route::controller(UpdateDataController::class)->prefix('update')->group(function(){
        Route::post('/customer','updateCustomer');
        // Route::post('/influencer/{id}','updateInfluncer');
        Route::post('/influencer/info','updatePersonalInfluncerData');
        Route::post('/influencer/media','updateMediaDetailsInfluncer');
        Route::post('/influencer/extra','updateExtraInfoInfluencers');
        Route::post('/influencer/price','updatePriceInfoInfluencers');
        Route::post('/influencer/deleteFile/{id}','deleteFiles');
        Route::post('/influencer/uploadFile/{type}','uploadFiles');
     
    });

      #COUNTRIES ROUTES
      Route::controller(CountryController::class)->prefix('countries')->group(function(){
        Route::get('/','index');
    });

      #BANKS ROUTES
      Route::controller(BankController::class)->prefix('banks')->group(function(){
        Route::get('/','index');
    });

      #ADDRESSES ROUTES
      Route::controller(AddressController::class)->prefix('addresses')->group(function(){
        Route::get('/','index');
    });

    #GET PRIVACY
    Route::controller(PrivacyController::class)->prefix('privacy')->group(function(){
        Route::get('/','index');
    });


    #GET TERMS AND CONDITIONS
    Route::controller(TermsAndConditionsController::class)->prefix('terms')->group(function(){
        Route::get('/','index');
    });


    #GET FAQ'S
    Route::controller(FaqController::class)->prefix('faq')->group(function(){
        Route::get('/','index');
    });

    #GET CITIES
    Route::controller(CityController::class)->prefix('cities')->group(function(){
        Route::get('/{country_id}','index');
    });

    #GET AREAS
    Route::controller(AreaController::class)->prefix('areas')->group(function(){
        Route::get('/{id}','index');
    });

    #GET REGIONS
    Route::controller(RegionController::class)->prefix('regions')->group(function(){
        Route::get('/{country_id}','index');
    });

     #CATEGORIES ROUTES
     Route::controller(CategoryController::class)->prefix('categories')->group(function(){
        Route::get('/','index');
        Route::get('/influncers','getInfluncerCategories');
    });

     #GET SLIDES
     Route::controller(SlideController::class)->prefix('slides')->group(function(){
        Route::get('/','index');
    });

    #GET CAMPAIGN GOALS
    Route::controller(CampaignGoalController::class)->prefix('campaignGoals')->group(function(){
        Route::get('/','index');
        Route::get('/rejectReasons','rejectReasons');
    });

    
    Route::middleware('api_auth')->group(function(){

        
        #USER DETAILS
        Route::get('users/details/{id?}',[AuthController::class,'details']);
        # AUTH ROUTES
        Route::controller(AuthController::class)->group(function(){
            Route::post('logout','logout');
            Route::post('refresh','refresh');
            Route::post('me','me');
            Route::post('changePassword','changePassword');
        });

        #Ad ROUTES
        Route::prefix('ads')->controller(AdController::class)->group(function(){
            Route::get('get/{status}','index');
            Route::post('create','store')->middleware('check_customer');
            Route::get('details/{id}','details');
            Route::get('contract/{ad_id}','get_ad_contract');
            Route::post('contract/accept_contract/{contract_id}','accept_ad_contract');
            Route::post('contract/customer/accept_contract/{contract_id}','accept_customer_ad_contract');
            Route::get('search/{query}','search');
            Route::get('influencers/{influncer_id}/{status?}','get_influencer_ads');
            Route::get('customers/{customer_id}/{status?}','get_customers_ads');
            Route::get('matched/Influencer/{id}','getMatchedInfluencers');
            Route::get('matched/not_chosen_inf/{id}/{removed_inf_id}/{replace_permission?}','getMatchedInfluencersNotChosen');
            Route::get('matched/replace_influencer/{id}/{removed_influencer}/{chosen_influencer}','replace_matched_influencer');
            Route::get('before_payment/{id}','before_payment');
            Route::post('pay_now/{id}','pay_now');
            Route::get('back_up_influencers/{id}/{removed_inf}','back_up_influencers');
            Route::get('/ads/contract/{ad_id}','get_ad_contract');
            Route::post('fullPayment/{ad_id}','full_payment');
            Route::get('completeAd/{ad_id}','completeAd');
            Route::post('addMatch','addMatch');
            Route::post('changeMatchedStatus','changeMatchStatus');
        });

        #CATEGORIES ROUTES
        Route::controller(CategoryController::class)->prefix('categories')->group(function(){
            Route::get('/search/{query}','search');
        });

        #GET INFLUENECER
        Route::controller(InfluenecerController::class)->prefix('influenecers')->group(function(){
            Route::get('/get_matched_influencers/{category_id}','get_matched_influencers');
        });

        #GET NOTIFICATION
        Route::controller(NotificationController::class)->prefix('notifications')->group(function(){
          //  dd('here');
            Route::post('markAsRead/{id}','readNotification');
            Route::get('/{type}','index');
        });

       
    
        



    });
});

