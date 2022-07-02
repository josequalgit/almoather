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
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\FrontEnd\ContactController;
use App\Http\Middleware\LanguageMiddleware;

Route::group(['prefix'=>'auth','middleware' => 'language'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::get('campaign/pdf/{id}',[AdController::class,'getCampaignContract'])->name('contractApi');
    Route::get('changeLanguage/{lang}',[AuthController::class,'changeLang']);


    Route::get('contact-information',[ContactUsController::class,'contactInformation']);
    Route::post('contact',[ContactController::class,'store_contact_messages']);

    #SEND EMAIL ROUTE
    Route::controller(MailController::class)->prefix('mail')->group(function(){
        Route::post('send','basic_email');
        Route::post('checkCode','checkCode')->name('activateCode');
        Route::post('checkCodeWeb','checkCodeWeb')->name('activateCodeWeb');
        Route::post('forgetPassword','forgetPassword');
    });

    #REGISTER ROUTES
    Route::controller(RegisterController::class)->prefix('register')->group(function(){
        Route::post('/influncer','registerInfluncer')->name('register_influencer');
        Route::post('/customer','registerCustomer')->name('register_customer');
        Route::get('/verify','verify');
        Route::post('/customer/update/{id}',[RegisterController::class,'updateCustomer']);
        Route::post('/checkUnique','checkUniqueData')->name('checkUniqueData');
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
        Route::post('/influencer/updateSubscribers','updateSubscribers');
     
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
        Route::get('return-policy','indexPolicy');
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
    Route::controller(CityController::class)->prefix('cities')->name('cities.')->group(function(){
        Route::get('/{region_id}','index')->name('getCities');;
    });

    #GET AREAS
    Route::controller(AreaController::class)->prefix('areas')->group(function(){
        Route::get('/{id}','index');
    });

    #GET REGIONS
    Route::controller(RegionController::class)->prefix('regions')->name('regions.')->group(function(){
        Route::get('/{country_id}','index')->name('index');
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
        Route::get('/rejectReasons/{type?}','rejectReasons');
    });

    
    Route::middleware('api_auth')->group(function(){

        
        #USER DETAILS
        Route::get('users/details/{id?}/{type?}',[AuthController::class,'details'])->where('type', 'customer|influencer');
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
            Route::get('matched/not_chosen_inf/{id}/{removed_inf_id}','getMatchedInfluencersNotChosen');
            Route::get('matched/replace_influencer/{id}/{removed_influencer}/{chosen_influencer}','replace_matched_influencer');
            Route::get('preview_ad_matches/{id}','before_payment');
            Route::post('confirm_matches/{id}','confirm_matches');
            Route::get('completePay/{id}','pay_now');
            Route::get('back_up_influencers/{id}/{removed_inf}','back_up_influencers');
            Route::get('/ads/contract/{ad_id}','get_ad_contract');
            Route::post('fullPayment/{ad_id}','full_payment');
            Route::get('completeAd/{ad_id}','completeAd');
            Route::post('addMatch','addMatch');
            Route::post('changeMatchedStatus','changeMatchStatus');
            Route::post('check_payment/{ad_id}','check_payment');
            Route::get('get_ad_influencers_match/{ad_id}','get_ad_influencers_match');
            Route::post('update/{ad_id}','update');
            Route::get('ad_details_update/{ad_id}','ad_details_update');
            Route::post('/upload_media/{file_id}/{type}','uploadMedia')->where('type','remove|add|replace');
            Route::get('get_ad_relation','get_ads_relation');
        });

        #CATEGORIES ROUTES
        Route::controller(CategoryController::class)->prefix('categories')->group(function(){
            Route::get('/search/{query}','search');
        });

        #GET INFLUENECER
        Route::controller(InfluenecerController::class)->prefix('influenecers')->group(function(){
            Route::get('/get_matched_influencers/{category_id}','get_matched_influencers');
        });

        Route::controller(InfluenecerController::class)->prefix('influencers')->group(function(){
            Route::get('/get-medias','getMedias');
            Route::post('/upload-media','uploadMedia');
            Route::post('/delete-media/{id}','deleteGalleryMedia');
        });

        #GET NOTIFICATION
        Route::controller(NotificationController::class)->prefix('notifications')->group(function(){
            Route::get('/','index');
            Route::post('markAsRead/{id}','readNotification');
        });

        #GET CHAT MESSAGES
        Route::controller(ChatController::class)->prefix('chats')->group(function(){
            Route::get('/{id}/{type}','index')->where('type','support|app');
            Route::post('/upload','uploadFiles');
        });

       
    
        



    });
});
