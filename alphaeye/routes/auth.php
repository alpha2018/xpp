<?php
Route::group(['namespace' => 'Core\\Http\\Controllers\\Auth'], function () {
    //--------- 登录路由 ----------//
    Route::get('auth/login', 'LoginController@getLogin');
    Route::post('auth/login', 'LoginController@postLogin');
    Route::get('auth/logout', 'LoginController@getLogout');
    //--------- 注册路由 ----------/
    Route::get('auth/register', 'LoginController@getRegister');
    Route::post('auth/register', 'LoginController@postRegister');

    //--------- 验证路由 ----------//
    Route::post('register/validate/email', 'LoginController@postValidateEmail');

//    Route::get('password/reset', '\\Modules\\Admin\\Controller\\PasswordController@getEmail');
//    Route::post('password/email', '\\Modules\\Admin\\Controller\\PasswordController@postEmail');

    //---------- 密码重置链接请求路由 ----------//
    Route::get('password/email', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');
    //------------- 密码重置路由 -----------//
    /* Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset'); */

    Route::get('password/reset/{token}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
});
