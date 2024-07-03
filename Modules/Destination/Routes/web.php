<?php

Route::group(['middleware' => ['auth']], function () {
    Route::resource('destination', 'DestinationController');
});
