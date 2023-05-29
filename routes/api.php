<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/test', [\App\Http\Controllers\Api\TestController::class, 'index'])->name('api.test');
Route::get('/message', \App\Http\Controllers\Api\MessageController::class)->name('api.message');
Route::get('/category', \App\Http\Controllers\Api\CategoryController::class)->name('api.category');
Route::post('/cat', \App\Http\Controllers\Api\CatController::class)->name('api.cat');



Route::post('/login', [\App\Http\Controllers\Api\ChatloginContorller::class, 'login'])->name('api.chat.login');
Route::post('/loginkey', [\App\Http\Controllers\Api\ChatloginContorller::class, 'loginkey'])->name('api.chat.loginkey');
Route::post('/logout', [\App\Http\Controllers\Api\ChatloginContorller::class, 'logout'])->name('api.chat.logout');

Route::middleware('apichat_id')->group(function () {
    //Route::get('/chat/sign', [App\Http\Controllers\ChatController::class, 'sign'])->name('chat.sign');
    Route::get('/chatlogin', [\App\Http\Controllers\Api\ChatloginContorller::class, 'index'])->name('api.chat.login');
});



Route::get('/bot', function (){
//return 66666;
//return var_dump(openssl_get_cert_locations());
   return Http::get('https://api.telegram.org/bot5903822805:AAEqYIWvKrOI_p36GlrxS9RIhzrYnw2wGw4/sendMessage',
        [
            'chat_id' => 360336947,
            'text' => '<i> -- </i>',
            'parse_mode' => 'html',
        ]);
});
Route::post('/bot', \App\Http\Controllers\Api\ApiBotController::class)->name('api.bot');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);

});

Route::prefix('categories')->middleware('jwt.auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index'])->name('api.categories.index');

});


Route::prefix('vue')->group(function () {
    Route::prefix('messages')->middleware('apichat_id')->group(function () {
        Route::get('/', \App\Http\Controllers\Vue\Message\IndexController::class)->name('vue.messages.index');
        Route::post('/', \App\Http\Controllers\Vue\Message\StoreController::class)->name('vue.messages.store');
        Route::get('/{message}', \App\Http\Controllers\Vue\Message\ShowController::class)->name('vue.messages.show');
        Route::get('/{message}/edit', \App\Http\Controllers\Vue\Message\EditController::class)->name('vue.messages.edit');
        Route::patch('/{message}', \App\Http\Controllers\Vue\Message\UpdateController::class)->name('vue.messages.update');
        Route::delete('/{message}',\App\Http\Controllers\Vue\Message\DeleteController::class)->name('vue.messages.destroy');
    });
    Route::prefix('categories')->group(function () {
        Route::get('/', \App\Http\Controllers\Vue\Category\IndexController::class)->name('vue.categories.index');
        Route::post('/', \App\Http\Controllers\Vue\Category\StoreController::class)->name('vue.categories.store');
        Route::get('/{category}', \App\Http\Controllers\Vue\Category\ShowController::class)->name('vue.categories.show');
        Route::get('/{category}/edit', \App\Http\Controllers\Vue\Category\EditController::class)->name('vue.categories.edit');
        Route::patch('/{category}', \App\Http\Controllers\Vue\Category\UpdateController::class)->name('vue.categories.update');
        Route::delete('/{category}',\App\Http\Controllers\Vue\Category\DeleteController::class)->name('vue.categories.destroy');
    });
    Route::prefix('tags')->group(function () {
        Route::get('/', \App\Http\Controllers\Vue\Tag\IndexController::class)->name('vue.tags.index');
        Route::post('/', \App\Http\Controllers\Vue\Tag\StoreController::class)->name('vue.tags.store');
        Route::get('/{tag}', \App\Http\Controllers\Vue\Tag\ShowController::class)->name('vue.tags.show');
        Route::get('/{tag}/edit', \App\Http\Controllers\Vue\Tag\EditController::class)->name('vue.tags.edit');
        Route::patch('/{tag}', \App\Http\Controllers\Vue\Tag\UpdateController::class)->name('vue.tags.update');
        Route::delete('/{tag}',\App\Http\Controllers\Vue\Tag\DeleteController::class)->name('vue.tags.destroy');
    });

    Route::prefix('results')->group(function () {
        Route::get('/', \App\Http\Controllers\Vue\Result\IndexController::class)->name('vue.results.index');
        Route::post('/', \App\Http\Controllers\Vue\Result\StoreController::class)->name('vue.results.store');
        Route::get('/{result}', \App\Http\Controllers\Vue\Result\ShowController::class)->name('vue.results.show');
        Route::get('/{result}/edit', \App\Http\Controllers\Vue\Result\EditController::class)->name('vue.results.edit');
        Route::patch('/{result}', \App\Http\Controllers\Vue\Result\UpdateController::class)->name('vue.results.update');
        Route::delete('/{result}',\App\Http\Controllers\Vue\Result\DeleteController::class)->name('vue.tags.destroy');
    });
    Route::prefix('graphic')->group(function () {
        Route::get('/', \App\Http\Controllers\Vue\Graphic\IndexController::class)->name('vue.graphic.index');
    });

});
