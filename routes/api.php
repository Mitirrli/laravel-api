<?php

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

Route::post('/demo', ['App\Http\Controllers\DemoController', 'save'])->name('一个demo');

Route::fallback(function () {
    return new \Illuminate\Http\Response('', 404);
});
