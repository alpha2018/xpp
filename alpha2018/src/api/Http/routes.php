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

//Route::group(['middleware' => 'auth'], function () {
//    foreach(glob( base_path(route_path()) ) as $route){
//        require $route;
//    }
//});



// // 发送密码重置链接路由
// Route::get('password/email', 'Auth\PasswordController@getEmail');
// Route::post('password/email', 'Auth\PasswordController@postEmail');
//
// // 密码重置路由
// Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
// Route::post('password/reset', 'Auth\PasswordController@postReset');

// 后台主页
Route::get('/', 'Backend\HomeController@getIndex');

#-------- module控制器路由 --------
Route::get('module.moduletree','Admin.ModuleController@getModuleTree', ['relate' => 'module.index']);
Route::resource('module','Admin.ModuleController');

#--------- 用户控制器 -------------


Route::get('user/resetpassword','Admin\UserController@resetPassword');
Route::post('user/resetpassword','Admin\UserController@updatePassword');
Route::post('user/update','Admin\UserController@Update');
Route::post('user/all','Admin\UserTableController@all')->name('user.all');
Route::resource('user','Admin\UserController');

Route::post('role/all','Admin\\Role\\RoleTableController@all')->name('role.all');
Route::resource('role','Admin\\Role\\RoleController');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('test',function (){
   return apiResponse();
});

Route::get('note/index','Note\\NoteController@index')->name('note.index');

Route::get('note/{id}','Note\\NoteController@index')->name('note.show');

Route::post('note/folders','Note\\NoteController@getFolders');

