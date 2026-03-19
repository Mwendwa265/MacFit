<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GymController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserOtpController;
use App\Http\Controllers\verifyemailcontroller;
use Illuminate\Foundation\Console\UpCommand;
use App\Http\Controllers\UserController;

    // Public Routes
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/login', [Authcontroller::class, 'login']);
Route::post('/verify-otp',[UserOtpController::class, 'verifyOtp']);
            // Email Verification
Route::get('/email/verify/{id}/{hash}', [verifyemailcontroller::class, 'verify'])
        ->name('verification.verify')
        ->middleware(['signed', 'throttle:6,1']);
Route::post('/email/verify/{id}/{hash}', [verifyemailcontroller::class, 'resend'])
        ->middleware(['signed', 'throttle:6,1']);

        // Protected Routes
Route::middleware('auth:sanctum')->group(function () {
 
Route::get('/userInfo', [Authcontroller::class, 'userInfo']); 

Route::post('/logout', [Authcontroller::class, 'logout']);    


Route::post('/saveRoles', [RoleController::class, 'createRole']);
Route::get('/getRoles', [RoleController::class, 'readAllRoles']);
Route::get('/getRoles/{id}', [RoleController::class, 'readRole']);
Route::put('/updateRoles/{id}', [RoleController::class, 'updateRole']);
Route::delete('/deleteRole/{id}', [RoleController::class, 'deleteRole']);

Route::post('/saveEquipment', [EquipmentController::class, 'createEquipment']);
Route::get('/getEquipments', [EquipmentController::class, 'readAllEquipments']);
Route::get('/getEquipment/{id}', [EquipmentController::class, 'readEquipment']);
Route::put('/updateEquipment/{id}', [EquipmentController::class, 'updateEquipment']);
Route::delete('/deleteEquipment/{id}', [EquipmentController::class, 'deleteEquipment']);


Route::post('/savecategory', [CategoryController::class, 'createcategory']);
Route::get('/getcategories', [CategoryController::class, 'readAllcategories']);
Route::get('/getcategory/{id}', [CategoryController::class, 'readcategory']);
Route::post('/updatecategory/{id}', [CategoryController::class, 'updatecategory']);
Route::delete('/deletecategory/{id}', [CategoryController::class, 'deletecategory']);

Route::post('/saveGym', [GymController::class, 'createGym']);
Route::get('/getGyms', [GymController::class, 'readAllGyms']);
Route::get('/getGym/{id}', [GymController::class, 'readGym']);
Route::post('/updateGym/{id}', [GymController::class, 'updateGym']);
Route::delete('/deleteGym/{id}', [GymController::class, 'deleteGym']);

Route::post('/saveBundle', [BundleController::class, 'createBundle']);
Route::get('/getBundles', [BundleController::class, 'readAllBundles']);
Route::get('/getBundle/{id}', [BundleController::class, 'readBundle']);
Route::post('/updateBundle/{id}', [BundleController::class, 'updateBundle']);
Route::delete('/deleteBundle/{id}', [BundleController::class, 'deleteBundle']);

Route::post('/saveSubscription', [SubscriptionController::class, 'createSubscription']);
Route::get('/getSubscriptions', [SubscriptionController::class, 'readAllSubscriptions']);
Route::get('/getSubscription/{id}', [SubscriptionController::class, 'readSubscription']);
Route::post('/updateSubscription/{id}', [SubscriptionController::class, 'updateSubscription']);
Route::delete('/deleteSubscription/{id}', [SubscriptionController::class, 'deleteSubscription']);

route::resource('users', UserController::class);
});