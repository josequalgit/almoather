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
use App\Http\Controllers\ContractController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\CampaignGoalController;
use App\Http\Controllers\BusinessManagerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\ChatController;

Route::redirect('/','/dashboard/admins')->name('home');
Route::get('/test-msg',[ChatController::class,'sendMessageTo'])->name('test');


Route::middleware('checkLogin')->controller(LoginController::class)->group(function(){
    Route::get('admin/login','index')->name('login');
    Route::post('admin/loginSubmit','login')->name('loginSubmit');    
});

Route::middleware('auth')->prefix('dashboard')->group(function(){



    //Analysis Routes
    Route::name('dashboard.')->controller(HomeController::class)->group(function(){
        Route::get('/','index')->name('home');

        Route::get('/notifications/readNotification/{id}',[NotificationController::class,'read'])->name('readNotification');


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

        Route::middleware('role_or_permission:superAdmin|Edit Influncer|See Influncer|Contracts Manager')->name('influncers.')->controller(InfluncerController::class)->group(function(){
            Route::get('influncer/{status?}','index')->name('index')->middleware('permission:Edit Influncer|See Influncer');
            Route::get('influncer/edit/{id}','edit')->name('edit')->middleware('permission:Edit Influncer');
            Route::get('allInfluncerWithViews/','allInfluncerWithViews')->name('allInfluncerWithViews')->middleware('role:Contracts Manager|superAdmin');
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
            Route::get('/ads/edit/{id}/{editable?}','edit')->name('edit')->middleware('permission:Edit Ads');
            Route::post('/ads/UploadVideo/{ad_id}','uploadVideo')->name('uploadVideo');
            Route::post('/ads/UploadImage/{ad_id}','uploadImage')->name('uploadImage');
            Route::post('/ads/DeleteFile/{file_id}','deleteFile')->name('deleteFile');
            Route::post('/ads/updateBasic/{ad_id}','update_basic')->name('updateBasic');
            Route::post('/ads/update/{id}/{confirm?}','update')->name('update')->middleware('permission:Edit Ads');
            Route::get('/ads/changeMatch/{ad_id}/{removed_inf}/{chosen_inf}','changeMatch')->name('changeMatch')->middleware('permission:Edit Ads');
            Route::get('/ads/seeMatched/{ad_id}','seeMatched')->name('seeMatched');
            Route::get('/ads/contract/edit/{ad_id}','editContract')->name('editContract');
            Route::post('/ads/contract/update/{ad_id}','updateContract')->name('updateContract');
            Route::post('/ads/UpdateAddress/{id}','updateAddress')->name('updateAddress');
            Route::post('/ads/contract/influencers/{ad_id}','sendContractToInfluencer')->name('sendContractToInfluncer');
            Route::post('/ads/contract/customers/{contract_id}','sendContractToCustomer')->name('sendContractToCustomer');
            Route::get('/ads/contract/customers/seeInfluncer/{contract_id}','seeContractInfluencer')->name('seeContractInfluencer');
        });

        Route::middleware('role_or_permission:superAdmin|Edit Slide|See Slide|Create Slide|Delete Slide')->name('slides.')->controller(SlideController::class)->group(function(){
            Route::get('/slides','index')->name('index')->middleware('permission:See Slide');
            Route::get('/slides/create','create')->name('create')->middleware('permission:Create Slide');
            Route::post('/slides/store','store')->name('store')->middleware('permission:Create Slide');
            Route::get('/slides/edit/{id}','edit')->name('edit')->middleware('permission:Edit Slide');
            Route::post('/slides/update/{id}','update')->name('update')->middleware('permission:Edit Slide');
            Route::post('/slides/update/{id}','update')->name('update')->middleware('permission:Edit Slide');
            Route::get('/slides/delete/{id}','delete')->name('delete')->middleware('permission:Delete Slide');
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
        
        Route::middleware('role_or_permission:superAdmin|Contracts Manager|Edit Contract|Create Contract|See Contract|Delete Contract')->name('contracts.')->controller(ContractController::class)->group(function(){
            Route::get('/contract','index')->name('index')->middleware('permission:Edit Contract|Create Contract|See Contract|Delete Contract');
            Route::get('/contract/edit','edit')->name('edit')->middleware('permission:Edit Contract');
            Route::post('/contract/update/{type}','update')->name('update')->middleware('permission:Edit Contract');
            Route::get('/contract/create','create')->name('create')->middleware('permission:Create Contract');
            Route::post('/contract/store','store')->name('store')->middleware('permission:Create Contract');
            Route::get('/contract/delete/{id}','delete')->name('delete')->middleware('permission:Delete Contract');
            Route::get('/contract/active','get_active_contracts')->name('activeContract')->middleware('role:Contracts Manager|superAdmin');
            Route::post('/contract/changeStatus/{id}/{status}','change_status_contracts')->name('changeStatus')->middleware('role:Contracts Manager|superAdmin');
            Route::get('/contract/customers','customer_contracts')->name('customerContracts')->middleware('role:Contracts Manager|superAdmin');
        });

        Route::middleware('role_or_permission:superAdmin|See Notification|Create Notification|Edit Notification|Delete Notification')
        ->name('notifications.')
        ->controller(NotificationController::class)
        ->group(function(){
            Route::get('/notifications','index')->middleware('permission:See Notification')->name('index');
            Route::get('/notifications/create','create')->middleware('permission:Create Notification')->name('create');
            Route::post('/notifications/store','store')->middleware('permission:Create Notification')->name('store');
            Route::get('/notifications/edit/{id}','edit')->middleware('permission:Edit Notification')->name('edit');
            Route::post('/notifications/update/{id}','update')->middleware('permission:Edit Notification')->name('update');
            Route::get('/notifications/delete/{id}','delete')->middleware('permission:Delete Notification')->name('delete');
        });


        Route::middleware('role_or_permission:superAdmin|See Campaign Goal|Create Campaign Goal|Edit Campaign Goal|Delete Campaign Goal')
        ->name('campaignGoals.')
        ->controller(CampaignGoalController::class)
        ->group(function(){
            Route::get('/campaignGoals','index')->middleware('permission:See Campaign Goal')->name('index');
            Route::get('/campaignGoals/create','create')->middleware('permission:Create Campaign Goal')->name('create');
            Route::post('/campaignGoals/store','store')->middleware('permission:Create Campaign Goal')->name('store');
            Route::get('/campaignGoals/edit/{id}','edit')->middleware('permission:Edit Campaign Goal')->name('edit');
            Route::post('/campaignGoals/update/{id}','update')->middleware('permission:Edit Campaign Goal')->name('update');
            Route::get('/campaignGoals/delete/{id}','delete')->middleware('permission:Delete Campaign Goal')->name('delete');
        });


        Route::middleware('role_or_permission:superAdmin|Business Manager')
        ->name('businessManager.')
        ->prefix('businessManager')
        ->controller(BusinessManagerController::class)
        ->group(function(){
            Route::get('/canceled','canceledContract')->name('canceledContract');
            Route::get('/rejectedAds','rejectedAds')->name('rejectedAds');
        });

        Route::controller(CountryController::class)
        ->prefix('countries')
        ->name('countries.')
        ->group(function(){
            Route::get('/{id}','index')->name('index');
        });

        Route::controller(CityController::class)
        ->prefix('cities')
        ->name('cities.')
        ->group(function(){
            Route::get('/{id}','index')->name('index');
        });

        Route::controller(ReasonsController::class)
        ->middleware('role_or_permission:superAdmin|Edit Reason|Update Reason|Show Reason|Create Reason')
        ->prefix('reasons')
        ->name('reasons.')
        ->group(function(){
            Route::get('/','index')->name('index');
            Route::post('/store','store')->name('store');
            Route::get('/delete/{id}','delete')->name('delete');
        });

        Route::controller(ChatController::class)
        ->prefix('chat')
        ->name('chat.')
        ->group(function(){
            Route::get('/','index')->name('index');
            Route::post('/send','sendMessage')->name('send');
            Route::get('/get_messages/{user_id}','get_messages')->name('get_messages');
        });
        
        


        

    });
 
    Route::get('/logout',[HomeController::class,'logout'])->name('dashboard.logout');    
});


