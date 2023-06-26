<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FaqController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\AppController;

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

Route::post('/register', [UserController::class, 'store'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'index']);
    Route::get('/{id}', [FaqController::class, 'show']);
    Route::post('/', [FaqController::class, 'store']);
    Route::put('/{id}', [FaqController::class, 'update']);
    Route::delete('/{id}', [FaqController::class, 'destroy']);
});

Route::middleware(['auth:api'])->prefix('apps')->group(function () {
    Route::get('/', [AppController::class, 'index'])->name('app.index');
    Route::get('/{id}', [AppController::class, 'show'])->name('app.show');
    Route::post('/', [AppController::class, 'store'])->name('app.store');
    Route::put('/{id}', [AppController::class, 'update'])->name('app.update');
    Route::delete('/{id}', [AppController::class, 'destroy'])->name('app.destroy');
});
    
    
