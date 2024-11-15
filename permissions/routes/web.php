<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::middleware(['permission:admin'])->group(function () {
    Route::get('/', function () {   
        $route = Route::getRoutes();
        dd($route);
        return view('index');
    });

    Route::get('/table', function () {
        $users = User::paginate(10);
        return view('tables', compact('users'));
    });

    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.destroy');
});


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::middleware(['permission:Hr'])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');   
    });
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
