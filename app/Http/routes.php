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

Route::any('/test1', function (){

//    dd('0000-00-00 00:00:00' == 0);


    $month = request()->input('month');
    if(empty($month)){
        $month = date('m');
    }

    $firstDayOfMonth = date('Y-'.$month.'-01 00:00:00');

    $date = $firstDayOfMonth;

    $firstAndEndDayOfWeekByDate = function ($date) {
        $checkDate = function ($date) {
            return $date == date('Y-m-d H:i:s', strtotime($date)) ? 1 : 0;
        };
        if (strlen($date) == 19 && $checkDate($date)) {

        } elseif (strlen($date) == 10 && $checkDate($date . ' 00:00:00')) {
            $date = $date . ' 00:00:00';
        } else {

        }

        $theWeek = date('W', strtotime($date));
        $thisWeek = date('W', time());
        $diffWeek = $theWeek - $thisWeek;

        $date = new \DateTime();
        $date->modify("this week $diffWeek weeks");
        $firstDayOfWeek = $date->format('Y-m-d') . ' 00:00:00';
        $date->modify("this week +6 days");
        $endDayOfWeek = $date->format('Y-m-d') . ' 23:59:59';

        return [$firstDayOfWeek, $endDayOfWeek, $theWeek];
    };

    $arr = [];
    $time = strtotime($date);
    $daysTheMonth = date('t', $time);
    $endDayOfMonth = date('Y-m-'.$daysTheMonth.' 00:00:00', $time);
    while (true){
        list($firstDayOfWeek, $endDayOfWeek, $week) = $firstAndEndDayOfWeekByDate($date);
        if($firstDayOfWeek > $endDayOfMonth){
            break;
        }
        $arr[] = [
            'first_day' => $firstDayOfWeek,
            'end_day' => $endDayOfWeek,
            'week' => $week
        ];
        $date = date('Y-m-d H:i:s',strtotime($endDayOfWeek) + 1);
    }

    dd($arr);
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

