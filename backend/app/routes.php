<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

Route::get('/', function () {
    return View::make('index');
});

Route::group(array('prefix' => 'api'), function () {
    Route::post('/subnautica-feedback', 'FeedbackApiController@store');
    Route::get('/subnautica-feedback', 'FeedbackApiController@index');
    Route::get('/feedback/{id}', 'FeedbackApiController@show');
});