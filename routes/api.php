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

Route::name('test.')->prefix('test')->group(function () {
    Route::get('business', App\Http\Controllers\Business::class)->name('业务异常');
    Route::get('system', App\Http\Controllers\System::class)->name('系统异常');
});

Route::name('demo.')->prefix('demo')->group(function () {
    Route::post('/', ['App\Http\Controllers\Demos', 'save'])->name('保存');
    Route::get('list', ['App\Http\Controllers\Demos', 'list'])->middleware('etag')->name('列表');
});

Route::fallback(function () {
    return new \Illuminate\Http\Response('', 404);
});
