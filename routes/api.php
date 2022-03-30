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


Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::get('changeLanguage/{lang}',[AuthController::class,'changeLang']);

    #REGISTER ROUTES
    Route::controller(RegisterController::class)->prefix('register')->group(function(){
        Route::post('/influncer','registerInfluncer');
        Route::post('/cutomer','registerCustomer');
        Route::get('/verify/{id}','verify');
        Route::post('/customer/update/{id}',[RegisterController::class,'updateCustomer']);
    });

    #UPDATE ROUTES
    Route::controller(UpdateDataController::class)->prefix('update')->group(function(){
        Route::post('/customer/{id}','updateCustomer');
        Route::post('/influencer/{id}','updateInfluncer');
     
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
        Route::get('/{city_id}','index');
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
    
    Route::middleware('api_auth')->group(function(){

        
        #USER DETAILS
        Route::get('users/details',[AuthController::class,'details']);
        # AUTH ROUTES
        Route::controller(AuthController::class)->group(function(){
            Route::post('logout','logout');
            Route::post('refresh','refresh');
            Route::post('me','me');
        });

        #Ad ROUTES
        Route::prefix('ads')->controller(AdController::class)->group(function(){
            Route::get('get/{status}','index');
            Route::post('create','store')->middleware('check_customer');
            Route::get('details/{id}','details');
            Route::get('contract/{contract_id}','get_ad_contract');
            Route::put('contract/accept_contract/{contract_id}/{influencer_id}','accept_ad_contract');
            Route::get('search/{query}','search');
            Route::get('influencers/{influncer_id}/{status?}','get_influencer_ads');
            Route::get('customers/{customer_id}/{status?}','get_customers_ads');
            Route::get('matched/Influencer/{id}','getMatchedInfluencers');
            Route::get('matched/not_chosen_Influencer/{id}/{removed_inf_id}','getMatchedInfluencersNotChosen');
            Route::get('matched/replace_influencer/{id}/{removed_influencer}/{chosen_influencer}','getMatchedInfluencersNotChosen');

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
            Route::get('/{type}','index');
        });

    
        



    });
});