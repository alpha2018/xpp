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
//    $token = app(\AlphaCore\Utils\AuthUtils::class)->setToken($user, request());
//    dd($user, $token);
//});
Route::any('auth/login', 'Auth\\LoginController@postLogin');
Route::any('auth/check', 'Auth\\LoginController@postCheckToken');

Route::get('article/image/preview/{id}', 'Xpp\\ImageController@preview');
Route::get('article/image/{id}/{width}', 'Xpp\\ImageController@show');

Route::any('article/upload', 'Xpp\\ImageController@upload');
Route::resource('article', 'Xpp\\ArticleController');

Route::any('test_rsa', function (){
    config();
    app(\AlphaRsa\Rsa\Rsa::class);
});
Route::group(['middleware'=>'auth'], function (){
    Route::any('people/article', 'Xpp\\PeopleArticleController@index');
    Route::any('people/article/{id}', 'Xpp\\PeopleArticleController@show');
    Route::post('people/article/destroy/{id}', 'Xpp\\PeopleArticleController@destroy');
    Route::post('people/article/set/public/{id}', 'Xpp\\PeopleArticleController@postSetPublic');
    Route::post('people/article/set/private/{id}', 'Xpp\\PeopleArticleController@postSetPrivate');
});
Route::post('people/article/praise/{id}', 'Xpp\\PeopleArticleController@postPraise');

