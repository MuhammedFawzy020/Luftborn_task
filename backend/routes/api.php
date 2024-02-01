<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendEmailJob;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/send-emails', 'App\Http\Controllers\ShopController@sendEmails');
Route::get('/fetchUser' ,'App\Http\Controllers\AuthController@fetchUser');

Route::post('/login' ,'App\Http\Controllers\AuthController@login');
Route::get('/check-auth', 'App\Http\Controllers\AuthController@checkAuth');

Route::resource('shops' , ShopController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
