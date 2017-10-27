<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('pendonor', 'PendonorController@index')->name('pendonor');

Route::get('data-training', 'SampleController@training')->name('data.training');
Route::get('data-testing', 'SampleController@testing')->name('data.testing');
Route::get('data-learning', 'SampleController@learning')->name('data.learning');
Route::get('data-banding/{tglDt?}', 'SampleController@banding')->name('data.banding');
Route::get('proses-hitung/{data}', 'SampleController@proses')->name('proses-hitung');

Route::auth();

Route::get('/home', 'HomeController@index');
