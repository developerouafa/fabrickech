<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//? Api routes
    Route::group(['middlware' => ['api'], 'namespace' => 'api'], function(){
        Route::get('/', [ShopController::class, 'welcome'])->name('welcome');
        Route::get('/shop', [ShopController::class, "index"])->name("shop");
        Route::get('/shopbycategory', [ShopController::class, "indexbycategory"])->name("shopbycategory");
        Route::get('/shopbycategoryindex', [ShopController::class, "indexbycategory"])->name("shopbycategoryindex");
        Route::get('/view/{id}', [ShopController::class, "view"])->name('view.product');

        Route::group(['prefix' => 'admin'], function(){
            Route::post('login', [AuthController::class, 'login'])->name('login');

            Route::post('logout', [AuthController::class, 'logout'])->middleware('admintoken:admin_token');

            //invalidate token security side

            //broken access controller user enumeration
        });

        Route::group(['prefix' => 'admin', 'middleware' => ['getadmintoken:admin_token']], function(){
            Route::post('profile', function(){
                // return 'Only authenticated admi can reach me';
                return Auth::user(); //return authenticated user data
            });
        });
    });
