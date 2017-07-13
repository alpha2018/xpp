<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/7/12
 * Time: 下午7:02
 */


Route::any('/', 'Wx\\WechatController@wx');
Route::any('/redirect_uri', function (){
    dd(request());
});
