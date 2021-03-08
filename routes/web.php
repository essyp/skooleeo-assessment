<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers', 'prefix' => 'blog/'], function () {
    Route::get('', 'BlogController@getBlog');
    Route::get('category/{id}', 'BlogController@getBlogCategory');
    Route::post('search-blog', 'BlogController@findBlogSearch');
    Route::get('search', 'BlogController@blogSearch');
    Route::get('{id}', 'BlogController@getBlogDetails');
    
});

Route::group(['middleware' => ['user'], 'namespace' => 'App\Http\Controllers', 'prefix' => 'user/'], function () {
    Route::get('account', 'UserController@getAccount');
    Route::get('blog', 'UserController@getBlog');
    Route::get('change-password', 'UserController@getChangePassword');
    Route::get('account-update', 'UserController@getAccountUpdate');
    Route::post('account-update', 'UserController@accountUpdate');
    Route::post('change-password', 'UserController@changePassword');
    Route::post('create-blog', 'UserController@createBlog');
    Route::post('update-blog', 'UserController@updateBlog');
    Route::post('blog-status', 'UserController@blogStatus');
});

Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'HomeController@getHome');
    Route::post('login-user', 'AuthController@loginUser');
    Route::post('register-user', 'AuthController@registerUser');
    Route::view('login','front/login');
    Route::view('register','front/register');
    Route::view('forgot-password','front/forgot-password');
    Route::get('reset-password/{id}', 'HomeController@getPasswordReset');
    Route::post('reset-password', 'HomeController@resetPassword');
    Route::post('recover-forgot-password', 'HomeController@forgotPassword');
    Route::get('logout', 'AuthController@logoutUser');
    Route::post('update-views', 'HomeController@updateViews');
    
    Route::post('/home/ajax/newsletter', 'HomeController@newsletter');
});



