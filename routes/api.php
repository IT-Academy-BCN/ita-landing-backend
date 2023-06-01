<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware(['auth:api'])->group(function () {
    Route::get('/apps', [AppController::class, 'index'])->name('app.index');
    Route::get('/apps/{id}', [AppController::class, 'show'])->name('app.show');
    Route::post('/apps', [AppController::class, 'store'])->name('app.store');
    Route::put('/apps/{id}', [AppController::class, 'update'])->name('app.update');
    Route::delete('/apps/{id}', [AppController::class, 'destroy'])->name('app.destroy');
//});