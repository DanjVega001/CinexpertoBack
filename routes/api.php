<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LevelControloller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TriviaController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, "login"]);
    Route::post('signup', [AuthController::class, "signup"]);
    Route::post('verification-email', [AuthController::class, "sendVerificationEmail"]);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, "logout"]);        
        //RUTA PARA MOSTRAR LOS NIVELES DE LAS TRIVIAS
        Route::get('levels', [LevelController::class, "getLevels"]);
    });

    // RUTAS SOLO PARA ADMIN
    Route::middleware(['auth:api', 'role:admin'])->group(function () {

    });


    // RUTAS SOLO PARA LOS USUARIOS
    Route::middleware(['auth:api', 'role:user'])->group(function () {

        // Mostrar los datos del usuario para el perfil
        Route::post('profile', [ProfileController::class, "getProfile"]);

        // Ruta para mostrar las trivias en base al level
        Route::get('trivias/{levelID}', [TriviaController::class, "getTriviasByLevelID"]);
    });
});
