<?php

use Illuminate\Support\Facades\Route;


Route::group([], function () {
    Route::resource('tourlocation', TourlocationController::class)->names('tourlocation');
});
