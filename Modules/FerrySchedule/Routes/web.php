<?php

// Route::group([], function () {
//     Route::resource('ferryschedule', FerryScheduleController::class)->names('ferryschedule');
// });
Route::group(['middleware' => ['auth']], function () {
    Route::resource('ferryschedule', 'FerryScheduleController');
    // Route::post('upload-image', 'FerryScheduleController@uploadImage');
});

