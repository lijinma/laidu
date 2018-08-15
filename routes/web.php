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

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('/search');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/books/all', 'BookController@index');
Route::get('/search', 'BookController@search');
Route::get('/books/public', 'BookController@public');
Route::get('/books/wechat', 'BookController@wechat');
Route::get('/books/create', 'BookController@create');
Route::post('/books/create', 'BookController@store');
Route::get('/accounts/create', 'WechatAccountController@create');
Route::post('/accounts/create', 'WechatAccountController@store');
Route::get('/books/add/{md5}', 'UserBookController@create');
Route::get('/books/remove/{md5}', 'UserBookController@destroy');
Route::get('/books/{name}/{page_name?}', 'BookController@show')->where('page_name', '(.*)');;
Route::get('/users/plans', 'UserPlanController@plans');
Route::get('/image', 'ImageController@index');
Route::get('/admin', 'AdminController@index');
Route::post('/admin/vip/add', 'AdminController@vipAdd');

Route::any('/wechat', 'WechatController@serve');
Route::get('/about', 'AboutController@index');
Route::get('/caifu', 'CaifuController@index');

