<?php

use Illuminate\Support\Facades\Route;
use Modules\Faqs\Http\Controllers\FaqsController;



Route::group([], function () {
    Route::resource('faqs', FaqsController::class)->names('faqs');
});
