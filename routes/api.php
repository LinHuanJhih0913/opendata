<?php

Route::get('/rain', 'RainController@index');
Route::get('/accident', 'AccidentController@index');
Route::get('/detail/{year}/{month}/{district?}', 'AccidentController@detail');
Route::get('/sdg/{district?}', 'AccidentController@sdg');