<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuyerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/user-profile', [AuthController::class, 'userProfile']);
Route::post('/password-reset', [AuthController::class, 'resetPassword']);
Route::post('/update-verif-code', [AuthController::class, 'updateVerificationCode']);
Route::post('/update-verif-status', [AuthController::class, 'updateVerificationStatus']);
Route::post("send-email", [EmailVerificationController::class, "sendEmail"]);

// user (seller)
Route::post("/insert-product", [UserController::class, 'uploadItem']);
Route::post('/get-product', [UserController::class, 'getProduct']);
Route::post('/update-product', [UserController::class, 'updateItem']);
Route::post('/set-pedagang-location', [UserController::class, 'setUserLatandLong']);
Route::get('/get-pedagang-location', [UserController::class, 'getUserLatandLong']);
Route::get('/get-buyer-tokens', [UserController::class, 'getBuyerTokens']);
Route::post('/get-user-profile', [UserController::class, 'getUserProfile']);
Route::post('/set-user-profile', [UserController::class, 'setUserProfile']);

// user (buyer)
Route::get('/get-seller', [BuyerController::class, 'getSeller']);
Route::post('/insert-buyer-tokens', [BuyerController::class, 'insertBuyerTokens']);
Route::post('/get-menu', [BuyerController::class, 'getMenu']);
Route::post('/set-buyer-location', [BuyerController::class, 'setBuyerLatandLong']);
Route::get('/get-buyer-location', [BuyerController::class, 'getBuyerLatandLong']);
Route::post('/get-buyer-profile', [BuyerController::class, 'getBuyerProfile']);
Route::post('/set-buyer-profile', [BuyerController::class, 'setBuyerProfile']);
