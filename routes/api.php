<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\FaqController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CodeController;
use App\Http\Controllers\api\AppController;

use App\Http\Controllers\api\ForgetController;

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
Route::group(['middleware' => ['api', 'locale']], function () {
Route::post('/register', [UserController::class, 'store'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'index']);
    Route::get('/{id}', [FaqController::class, 'show']);
    Route::post('/', [FaqController::class, 'store']);
    Route::put('/{id}', [FaqController::class, 'update']);
    Route::delete('/{id}', [FaqController::class, 'destroy']);
});

Route::post('/forgetpassword', [ForgetController::class, 'forgetPassword'])->name('forgetpassword');

Route::post('/send-code-by-email', [CodeController::class, 'sendCodeByEmail'])->middleware('auth:api');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/apps', [AppController::class, 'index'])->name('app.index');
    Route::get('/apps/{id}', [AppController::class, 'show'])->name('app.show');
    Route::post('/apps', [AppController::class, 'store'])->name('app.store');
    Route::put('/apps/{id}', [AppController::class, 'update'])->name('app.update');
    Route::delete('/apps/{id}', [AppController::class, 'destroy'])->name('app.destroy');
});

});