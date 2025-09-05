<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
// Rotas para autenticação
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

/* Middleware responsável por alimentar a Navbar com o usuário */
Route::middleware(['auth.jwt', 'inject.user'])->group(function () {
    Route::get('/Home', [HomeController::class, 'index'])->name('home');
    Route::prefix('/Admin')
        ->middleware(['auth.jwt', 'permissao:ROSFIELD_ADMIN'])
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::post('/cadastrar',[AdminController::class,'store'])->name('admin.cadastrar');
        });
});

