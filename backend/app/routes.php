<?php

Route::get('/', function () {
    return View::make('index');
});

Route::group(array('prefix' => 'api'), function () {
    Route::post('/subnautica-feedback', 'FeedbackApiController@store');
    Route::get('/subnautica-feedback', 'FeedbackApiController@index');
    Route::get('/feedback/{id}', 'FeedbackApiController@show');
});