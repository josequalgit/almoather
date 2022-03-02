<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CountryController;


Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[AuthController::class,'login']);

    #REGISTER ROUTES
    Route::controller(RegisterController::class)->prefix('register')->group(function(){
        Route::post('/influncer','registerInfluncer');
        Route::post('/cutomer','registerCustomer');
    });
    
    Route::middleware('api_auth')->group(function(){

        # AUTH ROUTES
        Route::controller(AuthController::class)->group(function(){
            Route::post('logout','logout');
            Route::post('refresh','refresh');
            Route::post('me','me');
        });

        #Ad ROUTES
        Route::middleware('check_customer')->controller(AdController::class)->group(function(){
            Route::post('ad/create','store');
        });

        #CATEGORIES ROUTES
        Route::controller(CategoryController::class)->prefix('categories')->group(function(){
            Route::get('/','index');
            Route::get('/influncers','getInfluncerCategories');
        });


        #COUNTRIES ROUTES
        Route::controller(CountryController::class)->prefix('countries')->group(function(){
            Route::get('/','index');
        });

        



    });
});
