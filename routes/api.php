<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
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


Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);

    #REGISTER ROUTES
    Route::controller(RegisterController::class)->prefix('register')->group(function(){
        Route::post('/influncer','registerInfluncer');
        Route::post('/cutomer','registerCustomer');
        Route::get('/verify/{id}','verify');
    });

      #COUNTRIES ROUTES
      Route::controller(CountryController::class)->prefix('countries')->group(function(){
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
    
    Route::middleware('api_auth')->group(function(){

        # AUTH ROUTES
        Route::controller(AuthController::class)->group(function(){
            Route::post('logout','logout');
            Route::post('refresh','refresh');
            Route::post('me','me');
        });

        #Ad ROUTES
        Route::prefix('ads')->controller(AdController::class)->group(function(){
            Route::post('create','store')->middleware('check_customer');
            Route::get('details/{id}','details');
            Route::get('contract/{contract_id}','get_ad_contract');
            Route::put('contract/accept_contract/{contract_id}/{influencer_id}','accept_ad_contract');
            Route::get('search/{query}','search');
        });

        #CATEGORIES ROUTES
        Route::controller(CategoryController::class)->prefix('categories')->group(function(){
            Route::get('/','index');
            Route::get('/influncers','getInfluncerCategories');
            Route::get('/search/{query}','search');
        });


      

        #GET INFLUENECER
        Route::controller(InfluenecerController::class)->prefix('influenecers')->group(function(){
            Route::get('/details/{id}','details');
            Route::get('/get_matched_influencers/{category_id}','get_matched_influencers');
        });

        #GET NOTIFICATION
        Route::controller(NotificationController::class)->prefix('notifications')->group(function(){
            Route::get('/{id}/{type}','index');
        });

        



    });
});
