<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::all();
    return view('dashboard', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/users', function () {
        $users = User::all();
        return view('users', compact('users'));
    })->name('users');
});

Route::middleware('auth')->group(function () {
    Route::get('/users/{user}', function (User $user) {
        return view('user', compact('user'));
    })->name('user');
});

Route::middleware('auth')->group(function () {
    Route::patch('/users/{user}', [UserController::class,'update'])->name('users.update');
    Route::post('/users', [UserController::class,'userStore'])->name('users.store');
});

Route::middleware('auth')->group(function () {
    Route::delete('/users/{user}', [UserController::class,'delete'])->name('users.destroy');
});

require __DIR__.'/auth.php';
