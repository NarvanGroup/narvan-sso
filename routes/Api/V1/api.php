<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\SocialMediaController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthenticationController::class)->group(static function () {
    Route::get('test', 'test');
    Route::post('loginOtp', 'loginOtp')->middleware(['prevent.multiple.logins']);
    Route::post('loginPassword', 'loginPassword')->middleware(['prevent.multiple.logins']);
    Route::post('userInquiry', 'userInquiry');
});


Route::middleware(['throttle:otp'])->group(function () {
    Route::post('otp', [AuthenticationController::class, 'otp']);
});

Route::middleware(['auth:sanctum', 'role.check'])->group(static function () {
    // Users route resources
    Route::post('users/authentication', [AuthenticationController::class, 'authentication']);
    Route::controller(UserController::class)->prefix('users')->group(static function () {
        Route::post('profile', 'profile');
        Route::post('logout', 'logout');
        Route::post('resetPassword', 'resetPassword');
    });
    Route::apiResource('users', UserController::class);

    //Users route resources
    Route::controller(AddressController::class)->prefix('addresses')->group(static function () {
        Route::get('getProvinces', 'getProvinces');
        Route::get('getCities/{provinceId}', 'getCities');
    });
    Route::apiResource('social-media', SocialMediaController::class);

    Route::apiResource('addresses', AddressController::class);

    //Cards route resources
    Route::apiResource('cards', CardController::class);
});
