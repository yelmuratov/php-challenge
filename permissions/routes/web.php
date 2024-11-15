<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Http\Controllers\MainController;

Route::middleware(['permission'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.destroy');
    Route::get('/forgot-password',[AuthController::class, 'ForgotPasswordPage'])->name('forgot-password');
});
Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');

Route::post('/loginUser', [AuthController::class, 'login'])->name('loginUser');
Route::post('/registerUser', [AuthController::class, 'register'])->name('registerUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
