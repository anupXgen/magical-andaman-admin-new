<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('package', fn (Request $request) => $request->user())->name('package');
// });
Route::post('packagelist', 'PackageController@packagelist_api');
Route::post('packagelist/{id}', 'PackageController@packagelist_api');

Route::post('imageinfo', 'PackageController@imageinfo_api');

Route::middleware('auth:api')->group(function () {
});
