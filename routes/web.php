<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users','UsersController');
#新增的路由分别对应会话控制器的三个动作：create, store, destroy
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');
#为用户的激活功能设定好路由，该路由将附带用户生成的激活令牌,在用户点击链接进行激活之后，我们需要将激活令牌通过路由参数传给控制器的指定动作
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
#Laravel 将密码重设功能相关的逻辑代码都放在了 ForgotPasswordController 和 ResetPasswordController 中，因此我们接下来需要将重设密码相关的路由指定到该控制器上
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
