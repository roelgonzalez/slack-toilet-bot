<?php

use App\Http\Controllers\ToiletController;
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

Route::get('wc-data', [ToiletController::class, 'storeToiletData']);
Route::get('get-wc-data', [ToiletController::class, 'showToiletData']);
Route::post('wc', [ToiletController::class, 'canUseToilet']);
