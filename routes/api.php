<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FaqController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CodeController;
use App\Http\Controllers\api\AppController;
use App\Http\Controllers\api\CollaboratorsController;

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

// recovery password
Route::post('/forget-password', [UserController::class, 'forgetPassword'])->name('forget.password');
Route::post('/reset-password/{token}', [UserController::class, 'resetPassword'])->name('reset.password');

Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/apps', [AppController::class, 'index'])->name('app.index');

Route::get('/collaborators/{area}', [CollaboratorsController::class, 'index']);


Route::middleware(['auth:api'])->prefix('faqs')->group(function () {

    Route::get('/{id}/{language?}', [FaqController::class, 'show'])->name('faq.show');
    Route::post('/{language?}', [FaqController::class, 'store'])->name('faq.store');
    Route::put('/{id}/{language?}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/{id}/{language?}', [FaqController::class, 'destroy'])->name('faq.destroy');
});


Route::post('/send-code-by-email', [CodeController::class, 'sendCodeByEmail'])->middleware('auth:api');

Route::middleware(['auth:api'])->prefix('apps')->group(function () {
    Route::get('/{id}', [AppController::class, 'show'])->name('app.show');
    Route::post('/', [AppController::class, 'store'])->name('app.store');
    Route::put('/{id}', [AppController::class, 'update'])->name('app.update');
    Route::delete('/{id}', [AppController::class, 'destroy'])->name('app.destroy');
});
