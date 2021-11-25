<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('phone-numbers', [\App\Http\Controllers\PhoneNumberController::class, 'index'])->name('phone-numbers.index');
Route::get('phone-numbers/statistics', [\App\Http\Controllers\PhoneNumberController::class, 'statistics'])->name('phone-numbers.statistics');
Route::get('phone-numbers/test/{phone}', [\App\Http\Controllers\PhoneNumberController::class, 'testNumber'])->name('phone-numbers.test-number');
