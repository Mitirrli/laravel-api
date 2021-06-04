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

use App\Http\Controllers\DemoController;

Route::post('/demo', [DemoController::class, 'save'])->name('一个demo');

Route::fallback(function () {
    return response('当前未找到路径', 404);
});
