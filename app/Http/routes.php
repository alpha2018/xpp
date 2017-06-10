<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//前台页面
Route::get('/', function (){
    return redirect('/static/index.html');
});

//Route::get('/test', function (){
//    $user = app(\App\Models\User::class)->find(1);
//    $token = app(\AlphaEyeCore\Utils\AuthUtils::class)->setToken($user, request());
//    dd($user, $token);
//});
Route::any('article/image/preview/{name}', 'Xpp\\ArticleController@getImagePreview');
Route::any('article/upload', 'Xpp\\ArticleController@upload');
Route::resource('article', 'Xpp\\ArticleController');

