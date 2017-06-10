<?php
Route::get('/', 'BlogController@Index');
Route::get('/about', 'BlogController@showAbout');
//Route::get('/{nav?}', 'BlogController@Navbar');//->where(['nav' => '^'.config('blog.nav_can_enter').'$']);
Route::get('/post/{slug?}', 'BlogController@showPost');
