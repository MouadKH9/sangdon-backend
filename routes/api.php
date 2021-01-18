<?php

use App\Http\Controllers\DonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//demandes api
Route::post('add',[demandeController::class, 'add']);
Route::get('showList/{id_user}',[demandeController::class, 'showList']);
Route::get('showDemande/{id_dem}',[demandeController::class, 'getDemandeById']);
Route::post('update/{id_dem}',[demandeController::class, 'update']);
//dons api
Route::apiResource('dons', DonController::class);
//centres api
Route::resource('centres', CentreController::class);
//villes api
Route::resource('villes', VilleController::class);
