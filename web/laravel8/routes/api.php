<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/register', 'Auth\RegisterController@register')->name('register');
// Route::post('/login', 'Auth\LoginController@login')->name('login');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// changed_for_laravel8
Route::post('/register', 'App\Http\Controllers\Auth\registerController@register');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::get('/user', fn() => Auth::user())->name('user');
//Route::get('/user', Auth::login($user));

// 写真投稿
//Route::post('/photos', 'PhotoController@create')->name('photo.create');
Route::post('/photos', 'App\Http\Controllers\PhotoController@create');

// 写真一覧
//Route::get('/photos', 'PhotoController@index')->name('photo.index');
Route::get('/photos', 'App\Http\Controllers\PhotoController@index');

// 写真詳細
//Route::get('/photos/{id}', 'PhotoController@show')->name('photo.show');
Route::get('/photos/{id}', 'App\Http\Controllers\PhotoController@show')->name('photo.show');

// コメント
//Route::post('/photos/{photo}/comments', 'PhotoController@addComment')->name('photo.comment');
Route::post('/photos/{photo}/comments', 'App\Http\Controllers\PhotoController@addComment')->name('photo.comment');

// いいね
//Route::put('/photos/{id}/like', 'PhotoController@like')->name('photo.like');
Route::put('/photos/{id}/like', 'App\Http\Controllers\PhotoController@like')->name('photo.like');

// いいね解除
//Route::delete('/photos/{id}/like', 'PhotoController@unlike');
Route::delete('/photos/{id}/like','App\Http\Controllers\PhotoController@unlike');

// トークンリフレッシュ
Route::get('/reflesh-token', function (\Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});

