<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']], function () {
    Route::resource('package', PackageController::class)->names('package');

    Route::get('package/itinerary/{id}','PackageController@addItinerary');
    Route::post('package/itinerary-save/{id}','PackageController@storeItinerary');

    Route::get('package/policy/{id}','PackageController@addPolicy');
    Route::post('package/policy-save/{id}','PackageController@storePolicy');

    Route::get('package/typeprice/{id}','PackageController@addTypeprice');
    Route::post('package/typeprice-save/{id}','PackageController@storeTypeprice');

    Route::get('package/hotel/{id}','PackageController@addHotel');
    Route::post('package/hotel-save/{id}','PackageController@storeHotel');

    Route::get('package/sightseeing/{id}','PackageController@addSightseeing');
    Route::post('package/sightseeing-save/{id}','PackageController@storeSightseeing');

    Route::get('package/activity/{id}','PackageController@addActivity');
    Route::post('package/activity-save/{id}','PackageController@storeActivity');

    Route::get('package/get-hotel-by-location/{id}','PackageController@hotelByLocation');
    Route::get('package/get-sightseeing-by-location/{id}','PackageController@sightseeingByLocation');
    Route::get('package/get-activity-by-location/{id}','PackageController@activityByLocation');
});
