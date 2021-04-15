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
//Config::get('constants.options');
if(session_status() == PHP_SESSION_NONE) session_start();

if(isset($_SESSION['user'])){
    Route::post('/', "App\Http\Controllers\poczekalnia@wykonaj");
    Route::get('/', "App\Http\Controllers\poczekalnia@wykonaj");
}else{
    Route::get('/', "App\Http\Controllers\stronaStartowa@wykonaj");
    Route::post('/', "App\Http\Controllers\stronaStartowa@logowanie");
}
