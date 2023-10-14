<?php

use App\Http\Controllers\API\EcoleController;
use App\Http\Controllers\API\EtudiantController;
use App\Http\Controllers\API\DocumentController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post('/auth/logout',[AuthController::class,'logout']);
    Route::get('/user',[AuthController::class,'user']);
    Route::apiResource('etudiants',EtudiantController::class);
    Route::apiResource('ecoles',EcoleController::class);
    Route::apiResource('documents', DocumentController::class);
   
    Route::apiResource('role',RoleController::class);
    Route::apiResource('users',UserController::class);
    Route::post('/sign-pdf/{id}',[PdfController::class,'signPdf']);
//     Route::get('/user', function (Request $request) {
//     return $request->user();
// });

});



Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::resource('verifications', VerificationController::class);