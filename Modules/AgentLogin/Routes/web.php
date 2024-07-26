<?php

use Illuminate\Support\Facades\Route;



// Route::group([], function () {
//     Route::resource('agentlogin', AgentLoginController::class)->names('agentlogin');
// });
Route::group(['middleware' => ['auth']], function () {
    Route::resource('agentlogin','AgentLoginController');
});

