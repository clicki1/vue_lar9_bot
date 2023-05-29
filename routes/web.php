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
//
//Route::get('/', function () {
//    return view('index');
//});
//
Auth::routes();
//


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/avito', [\App\Http\Controllers\AvitoController::class, 'index'])->name('avito.index');
Route::get('/avito/create', [\App\Http\Controllers\AvitoController::class, 'create'])->name('avito.create');
Route::post('/avito/storeimgphone', [\App\Http\Controllers\AvitoController::class, 'storeimgphone'])->name('avito.storeimgphone');
Route::post('/avito/addimgphone', [\App\Http\Controllers\AvitoController::class, 'addimgphone'])->name('avito.addimgphone');

Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
Route::post('/chat', [App\Http\Controllers\ChatController::class, 'login'])->name('chat.login');
Route::get('/chat/logout', [App\Http\Controllers\ChatController::class, 'logout'])->name('chat.logout');

Route::middleware('chat_id')->group(function () {
    Route::get('/chat/sign', [App\Http\Controllers\ChatController::class, 'sign'])->name('chat.sign');
});


Route::get('/vue', \App\Http\Controllers\Vue\IndexController::class)->name('vue.base');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::prefix('message')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\Message\IndexController::class)->name('admin.message.index');

    });

});

Route::prefix('vue')->group(function () {
    Route::get('/{page}', \App\Http\Controllers\Vue\IndexController::class)->where('page', '.*')->name('vue.index');
//    Route::prefix('message')->group(function () {
//        Route::get('/', \App\Http\Controllers\Vue\Message\IndexController::class)->name('vue.message.index');
//        Route::get('/create', \App\Http\Controllers\Vue\Message\CreateController::class)->name('vue.message.create');
//    });

});


//
Route::resource('/messages', App\Http\Controllers\MessageController::class);

Route::resource('/categories', \App\Http\Controllers\CategoryController::class);

Route::resource('/tags', \App\Http\Controllers\TagController::class);

Route::resource('/results', \App\Http\Controllers\ResultController::class);

Route::resource('/st', \App\Http\Controllers\StController::class);

Route::resource('/files', \App\Http\Controllers\FileController::class);

Route::get('/analiz', \App\Http\Controllers\AnalizController::class)->name('analiz.index');

Route::middleware('chat_id')->prefix('files')->group(function () {
    Route::get('/', [\App\Http\Controllers\File\FileController::class, 'index'])->name('files.index');
    Route::post('/storefile', [\App\Http\Controllers\File\FileController::class, 'storefile'])->name('files.storefile');
    Route::post('/uploadfile', [\App\Http\Controllers\File\FileController::class, 'uploadfile'])->name('files.uploadfile');
    Route::get('/{file}', [\App\Http\Controllers\File\FileController::class, 'deletefile'])->name('files.deletefile');
});
