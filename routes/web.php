<?php

use App\Http\Controllers\OAuth\eCommerce_Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::get('/oauth/login', [eCommerce_Client::class, 'getLogin'])->name('oauth.login');

Route::get('/callback', [eCommerce_Client::class, 'getCallback'])->name('oauth.callback');

Route::get('/connect', [eCommerce_Client::class, 'connectUser'])->name('oauth.connect');

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
