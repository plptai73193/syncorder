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

Route::get("/", function() {
    return view('install');
});

Route::get("/install", function() {
    return view('install');
});

Route::get("/login", function() {
    return view('login');
});

Route::get("/test", function() {
    return view('test');
});

Route::get("/account_select", function() {
    return view('account_select');
});

Route::post("/user", 'UserController@index')->name('user');