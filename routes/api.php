<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\demandeController;

use App\Http\Controllers\CentreController;
use App\Http\Controllers\VilleController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/user', [UserController::class, 'getAuthenticatedUser']);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'authenticate']);
Route::delete('/user', [UserController::class, 'delete']);
Route::post('/user', [UserController::class, 'update']);

Route::post('/reset-password-request', [PasswordResetRequestController::class, 'sendPasswordResetEmail']);
Route::post('/change-password', [ChangePasswordController::class, 'passwordResetProcess']);

Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
Route::post('/user/{id}', [UserController::class, 'updateUser']);
Route::get('/users', [UserController::class, 'allUsers']);

Route::post('add', [demandeController::class, 'add']);
Route::get('showList/{id_user}', [demandeController::class, 'showList']);
Route::get('showDemande/{id_dem}', [demandeController::class, 'getDemandeById']);
Route::post('update/{id_dem}', [demandeController::class, 'update']);
Route::resource('centres', CentreController::class);
Route::resource('villes', VilleController::class);
