<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Driver\DriverIdentityDocumentController;
use App\Http\Controllers\Api\Driver\DriverLicenseController;
use App\Http\Controllers\Api\Driver\DriverVehicleController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\Passenger\FriendController;
use App\Http\Controllers\Api\Passenger\NotificationController;
use App\Http\Controllers\Api\Passenger\PassengerController;
use App\Http\Controllers\Api\PassengerAddressController;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\RideController;
use App\Http\Controllers\Api\Settings\SettingController;
use Illuminate\Support\Facades\Route;

// ---------------- APIs of passenger with group ---------------- //

Route::group(['prefix' => 'passenger'], function () {
    Route::post('register', [PassportAuthController::class, 'registerPassenger']);
    Route::post('login', [PassportAuthController::class, 'loginPassenger']);
    Route::post('forget-password', [PassportAuthController::class, 'forgetPassword']);

    // Authenticated Routes of Passenger
    Route::middleware(['auth:api', 'role:passenger'])->group(function () {
        // Profile
        Route::get('profile', [PassengerController::class, 'index']);
        Route::post('profile/update', [PassengerController::class, 'updateProfile']);

        // update password
        Route::post('password/update', [PassengerController::class, 'updatePassword']);

        // account delete
        Route::delete('account/delete', [PassengerController::class, 'sofDeleteAcount']);

        // Logout
        Route::post('logout', [PassengerController::class, 'logout']);

        // favorite route
        Route::post('favorite-driver', [FavoriteController::class, 'favoriteDriver']);
        Route::get('favorite-drivers-list', [FavoriteController::class, 'listFavoriteDrivers']);
        Route::delete('unfavorite-driver', [FavoriteController::class, 'unfavoriteDriver']);
        Route::get('favorite-driver-details', [FavoriteController::class, 'favoriteDriverDetails']);
        // language
        Route::get('language', [SettingController::class, 'getLanguage']);

        // addressess
        Route::get('/passenger-addresses', [PassengerAddressController::class, 'index']);
        Route::post('/store/passenger-addresses', [PassengerAddressController::class, 'store']);
        Route::get('/passenger/details/{id}', [PassengerAddressController::class, 'show']);
        Route::post('/update/passenger-addresses/{id}', [PassengerAddressController::class, 'edit']);

        // passengers friends

        Route::post('/add-friend', [FriendController::class, 'addFriend']);
        Route::get('/get-friends', [FriendController::class, 'getFriends']);
        Route::post('/remove-friend', [FriendController::class, 'removeFriend']);
        Route::get('/friend-details', [FriendController::class, 'FriendDetails']);

        // suggest passengers
        Route::get('/suggest-passengers', [PassengerController::class, 'suggestPassengers']);

        Route::get('/search', [PassengerController::class, 'search']);

        // passenger notification
        Route::post('/rides/create', action: [RideController::class, 'createRide']);

        Route::get('/notifications/list', [NotificationController::class, 'getNotifications']);
        Route::put('/notifications/update', [NotificationController::class, 'updateNotifications']);

        Route::post('/accept/offer', [RideController::class, 'acceptRideOffer']);

        Route::get('/list/offers', [RideController::class, 'listOffers']);
        Route::get('/offers/details', [RideController::class, 'offerDetails']);


        Route::post('/ride/cancel', [RideController::class, 'cancelRidePassenger']);

        Route::post('review/driver', [RideController::class, 'postReview']);

    });
    // End of Authenticated Routes of Passenger

});

// End of APIs of passenger with group

// ---------------- APIs of driver with group ---------------- //
Route::group(['prefix' => 'driver'], function () {
    Route::post('register', [PassportAuthController::class, 'registerdriver']);
    Route::post('login', [PassportAuthController::class, 'logindriver']);
    Route::post('forget-password', [PassportAuthController::class, 'forgetPassword']);

    // Authenticated Routes of driver
    Route::middleware(['auth:api', 'role:driver'])->group(function () {
        // Profile
        Route::get('profile', [DriverController::class, 'index']);
        Route::post('profile/update', [DriverController::class, 'updateProfile']);

        // Driver Vehicle
        Route::get('vehicle', [DriverVehicleController::class, 'index']);
        Route::post('vehicle/update', [DriverVehicleController::class, 'updateVehicle']);

        // Driver License
        Route::get('license', [DriverLicenseController::class, 'index']);
        Route::post('license/update', [DriverLicenseController::class, 'updateLicense']);

        // Driver Identity document
        Route::get('identity', [DriverIdentityDocumentController::class, 'index']);
        Route::post('identity/update', [DriverIdentityDocumentController::class, 'updateIdentity']);

        // update password
        Route::post('password/update', [DriverController::class, 'updatePassword']);

        // account delete
        Route::delete('account/delete', [DriverController::class, 'sofDeleteAcount']);

        // Logout
        Route::post('logout', [DriverController::class, 'logout']);

        // language
        Route::get('language', [SettingController::class, 'getLanguage']);

        // notification setting

        Route::get('/notifications/list', [\App\Http\Controllers\Api\Driver\NotificationController::class, 'getNotifications']);
        Route::put('/notifications/update', [\App\Http\Controllers\Api\Driver\NotificationController::class, 'updateNotifications']);

        Route::post('/send/offer', [RideController::class, 'sendOffer']);
        Route::get('/rides/list', [RideController::class, 'listRides']);
        // start ride
        Route::post('/start/ride', [RideController::class, 'startRide']);
        // complete ride route
        Route::post('/complete/ride', [RideController::class, 'completeRide']);

        Route::post('/ride/cancel', [RideController::class, 'cancelRide']);
    });
    // End of Authenticated Routes of Driver

});

Route::get('privacy-policy', [SettingController::class, 'index']);
Route::post('contact-request', [ContactController::class, 'store']);

Route::get('help-support', [SettingController::class, 'getHelpSupport']);
Route::get('about-us', [SettingController::class, 'getAboutUs']);
