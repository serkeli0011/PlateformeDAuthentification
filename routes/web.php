<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/images/{path}',function($path){
   
    $headers = ["Content-type" => "image/png"];
    $p = ['app','images',$path];
    $pp= implode(DIRECTORY_SEPARATOR,$p);
    //dd(storage_path($pp));
   return response()->file(storage_path($pp), $headers);
    
});
Route::get('/signed/{path}',function($path){
   
    $headers = ["Content-type" => "application/pdf"];
    $p = ['app','signed',$path];
    $pp= implode(DIRECTORY_SEPARATOR,$p);
    //dd(storage_path($pp));
   return response()->file(storage_path($pp), $headers);
    
});
Route::get('/get-document/{id}', [FileController::class, 'getSigned']);