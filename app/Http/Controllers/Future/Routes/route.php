<?php
use Libs\Utils\Sys;
//Route::group(['middleware'=>'pjax'],function(){
    

    Route::get('/table', Sys::action('Future.TableController@Index'));
    Route::get('/form', Sys::action('Future.FormController@Index'));
//});

