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

Route::post('/demo', ['App\Http\Controllers\DemoController', 'save'])->name('保存demo');
Route::get('/demo/list', ['App\Http\Controllers\DemoController', 'list'])->middleware('etag')->name('列表demo');

Route::fallback(function () {
    return new \Illuminate\Http\Response('', 404);
});
