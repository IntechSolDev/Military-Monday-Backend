<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FilterController;

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

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

//User Auth Api Route
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('forgot', [UserController::class, 'forgot']);
    Route::post('confirm-code', [UserController::class, 'confirmCode']);
    Route::post('reset', [UserController::class, 'reset']);
    Route::post('change-password', [UserController::class, 'changePassword']); //Bear Token Needed
    Route::post('edit', [UserController::class, 'edit']);
    Route::post('verify', [UserController::class, 'verifyEmail']);
    Route::get('details', [UserController::class, 'details']); //Bear Token Needed
    Route::get('delete-user', [UserController::class, 'delete']); //Delete All user
    Route::post('update-fcm', [UserController::class, 'updateFcmToken']);

Route::group(['middleware' =>'auth:api'], function () {

    //Product
    Route::get('view-product-detail/{id}', [ProductController::class, 'viewProductDetail']); // Product Detail
    Route::get('view-product-by-status', [ProductController::class, 'viewProductByStatus']); // Product By Status
    Route::post('mark-as-sold', [ProductController::class, 'markAsSold']); // Product Mark as Sold


});

