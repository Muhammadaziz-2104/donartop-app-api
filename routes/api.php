<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BloodApiController;
use App\Http\Controllers\Api\BloodCenterApiController;
use App\Http\Controllers\Api\CitiesApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\BloodNeedsApiController;
use App\Http\Controllers\Api\DonarsApiController;
use App\Http\Controllers\Api\AdsApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AdminApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::apiResource('donars', DonarsApiController::class)->middleware('auth:sanctum');
Route::apiResource('blood_needs', BloodNeedsApiController::class)->middleware('auth:sanctum');

Route::apiResources(
    [
        'admins' => AdminApiController::class,
        'users' => UserApiController::class,
        'bloods' => BloodApiController::class,
        'blood_centers' => BloodCenterApiController::class,
        'cities' => CitiesApiController::class,
        'locations' => LocationApiController::class,
        'ads' => AdsApiController::class,
        'videos' => VideoApiController::class,
    ]
);
