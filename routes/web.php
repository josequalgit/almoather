<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InfluncerController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InfluncerCategoryController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\SlideController;

Route::redirect('/','/dashboard/admins')->name('home');


Route::middleware('checkLogin')->controller(LoginController::class)->group(function(){
    Route::get('admin/login','index')->name('login');
    Route::post('admin/loginSubmit','login')->name('loginSubmit');    
});

Route::middleware('auth')->prefix('dashboard')->group(function(){

    //Analysis Routes
    Route::name('dashboard.')->controller(HomeController::class)->group(function(){
        Route::get('/','index')->name('home');


        Route::middleware('role_or_permission:superAdmin|Edit Admin|Create Admin|See Admin|Delete Admin')->name('admins.')->controller(AdminController::class)->group(function(){
            Route::get('/admins','index')->name('index')->middleware('permission:Edit Admin|Create Admin|See Admin|Delete Admin');
            Route::get('/edit/{id}','edit')->name('edit')->middleware('permission:Edit Admin');
            Route::get('/editSuperAdmin','editSuperAdmin')->name('editSuperAdmin')->middleware('role:superAdmin');
            Route::post('/updateSuperAdmin','updateSuperAdmin')->name('updateSuperAdmin')->middleware('role:superAdmin');
            Route::post('/update/{id}','update')->name('update')->middleware('permission:Edit Admin');
            Route::get('/create','create')->name('create')->middleware('permission:Create Admin');
            Route::post('/store','store')->name('store')->middleware('permission:Create Admin');
            Route::get('/delete/{id}','delete')->name('delete')->middleware('permission:Delete Admin');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Influncer|See Influncer')->name('influncers.')->controller(InfluncerController::class)->group(function(){
            Route::get('influncer/{status?}','index')->name('index')->middleware('permission:Edit Influncer|See Influncer');
            Route::get('influncer/edit/{id}','edit')->name('edit')->middleware('permission:Edit Influncer');
            Route::post('influncer/updateStatus/{id}','updateStatus')->name('updateStatus')->middleware('permission:Edit Influncer');

        });

        Route::middleware('role_or_permission:superAdmin|Edit Customer|Create Customer|See Customer|Delete Customer')->name('customers.')->controller(CustomerController::class)->group(function(){
            Route::get('customer/','index')->name('index')->middleware('permission:Edit Customer|Create Customer|See Customer|Delete Customer');
            Route::get('customer/edit/{id}','edit')->name('edit')->middleware('permission:Edit Customer');
            Route::post('customer/update/{id}','update')->name('update')->middleware('permission:Edit Customer');
            Route::get('customer/create','create')->name('create')->middleware('permission:Create Customer');
            Route::post('customer/store','store')->name('store')->middleware('permission:Create Customer');
            Route::get('customer/delete/{id}','delete')->name('delete')->middleware('permission:Delete Customer');
            Route::post('customer/updateStatus/{id}','updateStatus')->name('updateStatus')->middleware('permission:Edit Customer');
            Route::get('customer/show ads/{id}','show_ads')->name('showAds')->middleware('permission:See Customer Ads');

        });
        
        Route::middleware('role_or_permission:superAdmin|Edit Role|Create Role|See Role|Delete Role')->name('roles.')->controller(RoleController::class)->group(function(){
            Route::get('/roles','index')->name('index')->middleware('permission:Edit Role|Create Role|See Role|Delete Role');
            Route::get('/roles/edit/{id}','edit')->name('edit')->middleware('permission:Edit Role');
            Route::post('/roles/update/{id}','update')->name('update')->middleware('permission:Edit Role');
            Route::get('/roles/create','create')->name('create')->middleware('permission:Create Role');
            Route::post('/roles/store','store')->name('store')->middleware('permission:Create Role');
            Route::get('/roles/delete/{id}','delete')->name('delete')->middleware('permission:Delete Role');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Category|Create Category|See Category|Delete Category')->name('categories.')->controller(CategoryController::class)->group(function(){
            Route::get('/categories','index')->name('index')->middleware('permission:Edit Category|Create Category|See Category|Delete Category');
            Route::get('/categories/edit/{id}','edit')->name('edit')->middleware('permission:Edit Category');
            Route::post('/categories/update/{id}','update')->name('update')->middleware('permission:Edit Category');
            Route::get('/categories/create','create')->name('create')->middleware('permission:Create Category');
            Route::post('/categories/store','store')->name('store')->middleware('permission:Create Category');
            Route::get('/categories/delete/{id}','delete')->name('delete')->middleware('permission:Delete Category');
        });
        Route::middleware('role_or_permission:superAdmin|Edit Influencer Category|Create Influencer Category|See Influencer Category|Delete Influencer Category')->name('influencerCategories.')->controller(InfluncerCategoryController::class)->group(function(){
            Route::get('/influencerCategories','index')->name('index')->middleware('permission:Edit Influencer Category|Create Influencer Category|See Influencer Category|Delete Influencer Category');
            Route::get('/influencerCategories/edit/{id}','edit')->name('edit')->middleware('permission:Edit Influencer Category');
            Route::post('/influencerCategories/update/{id}','update')->name('update')->middleware('permission:Edit Influencer Category');
            Route::get('/influencerCategories/create','create')->name('create')->middleware('permission:Create Influencer Category');
            Route::post('/influencerCategories/store','store')->name('store')->middleware('permission:Create Influencer Category');
            Route::get('/influencerCategories/delete/{id}','delete')->name('delete')->middleware('permission:Delete Influencer Category');
        });
        Route::middleware('role_or_permission:superAdmin|Edit SocialMedia|Create SocialMedia|See SocialMedia|Delete SocialMedia')->name('socialMedia.')->controller(SocialMediaController::class)->group(function(){
            Route::get('/SocialMedia','index')->name('index')->middleware('permission:Edit SocialMedia|Create SocialMedia|See SocialMedia|Delete SocialMedia');
            Route::get('/SocialMedia/edit/{id}','edit')->name('edit')->middleware('permission:Edit SocialMedia');
            Route::post('/SocialMedia/update/{id}','update')->name('update')->middleware('permission:Edit SocialMedia');
        });

        Route::middleware('role_or_permission:superAdmin|See Logs')->name('logs.')->controller(LogController::class)->group(function(){
            Route::get('/logs','index')->name('index')->middleware('permission:See Logs');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Contact Us')->name('contactUs.')->controller(ContactUsController::class)->group(function(){
            Route::get('/contactUs/edit','edit')->name('edit')->middleware('permission:Edit Contact Us');
            Route::post('/contactUs/update','update')->name('update')->middleware('permission:Edit Contact Us');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Ads|See Ads')->name('ads.')->controller(AdController::class)->group(function(){
            Route::get('/ads/{status?}','index')->name('index')->middleware('permission:See Ads');
            Route::get('/ads/edit/{id}','edit')->name('edit')->middleware('permission:Edit Ads');
            Route::post('/ads/update/{id}','update')->name('update')->middleware('permission:Edit Ads');
            Route::get('/ads/changeMatch/{ad_id}/{removed_inf}/{chosen_inf}','changeMatch')->name('changeMatch')->middleware('permission:Edit Ads');
            Route::get('/ads/seeMatched/{ad_id}','seeMatched')->name('seeMatched');

        });

        Route::middleware('role_or_permission:superAdmin|Edit Slide|See Slide|Create Slide|Delete Slide')->name('slides.')->controller(SlideController::class)->group(function(){
            Route::get('/slides','index')->name('index')->middleware('permission:See Slide');
            Route::get('/slides/create','create')->name('create')->middleware('permission:Create Slide');
            Route::post('/slides/store','store')->name('store')->middleware('permission:Create Slide');
            Route::get('/slides/edit/{id}','edit')->name('edit')->middleware('permission:Edit Slide');
            Route::post('/slides/update/{id}','update')->name('update')->middleware('permission:Edit Slide');
            Route::post('/slides/update/{id}','update')->name('update')->middleware('permission:Edit Slide');
            Route::post('/slides/delete/{id}','delete')->name('delete')->middleware('permission:Delete Slide');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Terms')->name('terms.')->controller(ContactUsController::class)->group(function(){
            Route::post('/terms/update','updateTerms')->name('update')->middleware('permission:Edit Terms');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Privacy')->name('privacy.')->controller(ContactUsController::class)->group(function(){
            Route::post('/privacy/update','updatePrivacy')->name('update')->middleware('permission:Edit Terms');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Faq|Create Faq|See Faq|Delete Faq')->name('faqs.')->controller(FaqController::class)->group(function(){
            Route::get('/Faq','index')->name('index')->middleware('permission:Edit Faq|Create Faq|See Faq|Delete Faq');
            Route::get('/Faq/edit/{id}','edit')->name('edit')->middleware('permission:Edit Faq');
            Route::post('/Faq/update/{id}','update')->name('update')->middleware('permission:Edit Faq');
            Route::get('/Faq/create','create')->name('create')->middleware('permission:Create Faq');
            Route::post('/Faq/store','store')->name('store')->middleware('permission:Create Faq');
            Route::get('/Faq/delete/{id}','delete')->name('delete')->middleware('permission:Delete Faq');
        });

        Route::middleware('role_or_permission:superAdmin|See Notification|Create Notification|Edit Notiification|Delete Notification')
        ->name('notifications.')
        ->controller(NotificationController::class)
        ->group(function(){
            Route::get('/notifications','index')->middleware('permission:See Notification')->name('index');
            Route::get('/notifications/create','create')->middleware('permission:Create Notification')->name('create');
            Route::post('/notifications/store','store')->middleware('permission:Create Notification')->name('store');
            Route::get('/notifications/edit/{id}','edit')->middleware('permission:Edit Notiification')->name('edit');
            Route::post('/notifications/update/{id}','update')->middleware('permission:Edit Notiification')->name('update');
            Route::get('/notifications/delete/{id}','delete')->middleware('permission:Delete Notification')->name('delete');
        });
        

    });
 
    Route::get('/logout',[HomeController::class,'logout'])->name('dashboard.logout');    
});

