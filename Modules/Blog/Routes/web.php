<?php

Route::group(['middleware' => ['auth']], function () {
    Route::resource('blog', 'BlogController');
});
