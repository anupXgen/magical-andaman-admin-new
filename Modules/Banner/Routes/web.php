<?php

Route::group(['middleware' => ['auth']], function () {
    Route::resource('banner', 'BannerController');
    Route::post('upload-image', 'BannerController@uploadImage');
});
