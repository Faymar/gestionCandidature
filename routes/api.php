<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});
Route::post('/register', [User::class, 'register']);

Route::group([
    'middleware' => 'api',
    'middleware' => 'estAdmin'
], function () {
    Route::post('/ajouterFormation', [FormationController::class, 'store']);
    Route::patch('/modifierFormation/{formation}', [FormationController::class, 'update']);
    Route::delete('/supprimerFormation/{formation}', [FormationController::class, 'destroy']);
    Route::get('/listeCandudature/{formation}', [DemandeController::class, 'listeCandudature']);
    Route::patch('/accepterDemande/{id_demande}/{formation}', [DemandeController::class, 'accepterDemande']);
    Route::patch('/reufuseDemande/{id_demande}/{formation}', [DemandeController::class, 'reufuseDemande']);
});

Route::get('/listFormations', [FormationController::class, 'index']);
Route::get('/voirFormation/{formation}', [FormationController::class, 'show']);

Route::group([
    'middleware' => 'api',
    'middleware' => 'estCandidat',
], function () {
    Route::post('/faireDemande/{formation}', [DemandeController::class, 'store']);
    Route::get('/candidat/listeDemande', [DemandeController::class, 'listDemande']);
});
