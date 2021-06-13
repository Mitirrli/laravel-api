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

use Illuminate\Support\Str;

Route::name('demo.')->prefix('demo')->group(function () {
    Route::post('/', ['App\Http\Controllers\DemoController', 'save'])->name('保存');
    Route::get('list', ['App\Http\Controllers\DemoController', 'list'])->middleware('etag')->name('列表');
});

Route::name('backend.')->prefix('test')->group(function () {
    Route::get('/', function () {
        Artisan::call('route:list --name="backend." --columns=name,uri --json');

        return response()->json(json_decode(Str::of(Artisan::output())->replace('backend.', ''), true));
    })->name('测试 artisan');
});

Route::fallback(function () {
    return new \Illuminate\Http\Response('', 404);
});
