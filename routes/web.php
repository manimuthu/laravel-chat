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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/list-users', 'HomeController@list')->name('list-users');
Route::post('/chats/store', 'ChatController@store_chats');
Route::post('/chats/fetch-all', 'ChatController@fetch_chats');
Route::post('/chats/fetch-pending', 'ChatController@fetch_pending_chats');
Route::post('/chats/fetch-new-user-chat', 'ChatController@fetch_new_user_chats');
