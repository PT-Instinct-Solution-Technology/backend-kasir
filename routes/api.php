<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BeliMenuController;

Route::group([
    'prefix' => 'auth'
  ], function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('import', [AuthController::class,'import']);
    Route::group([
        'middleware' => 'auth:api'
    ], function(){
        Route::post('logout', [AuthController::class,'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class,'me']);
        
        // voting process
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::get('/menus', [MenuController::class, 'listMenu']);
            Route::post('/menus', [MenuController::class, 'createMenu']);
            Route::post('/menus/{id}', [MenuController::class, 'updateMenu']);
            Route::delete('/menus/{id}', [MenuController::class, 'deleteMenu']);


            Route::get('/pembelian', [BeliMenuController::class, 'listPembelian']);
            Route::post('/pembelian', [BeliMenuController::class, 'createPembelian']);
            Route::put('/pembelian/{id}', [BeliMenuController::class, 'updatePembelian']);
            Route::delete('/pembelian/{id}', [BeliMenuController::class, 'deletePembelian']);
            Route::get('/pembelian-hari-ini', [BeliMenuController::class, 'pembelianHariIni']);
        });
    });
});



