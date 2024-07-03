<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {
    Route::resource('testimonial', TestimonialController::class)->names('testimonial');
});
