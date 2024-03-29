<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\TagController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\AuthController;
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

/* Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) { */
/*   return $request->user(); */
/* }); */

Route::prefix('v1/auth')->group(function () {
  Route::middleware(['api'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
  });
  Route::middleware(['api', 'auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
  });
});

Route::prefix('v1')->group(function() {

  Route::prefix((function() {
        $locale = request()->segment(3); 
        return LaravelLocalization::setLocale($locale);
    })())->group(function() {
        
        //'auth:api'
        Route::middleware(['ApiLocaleCookieRedirect','api', ])->group(function () {
            Route::apiResource('posts', PostController::class);
            Route::apiResource('categories', CategoryController::class);
            Route::apiResource('tags', TagController::class);
            Route::apiResource('users', UserController::class);
        });
    });

});
