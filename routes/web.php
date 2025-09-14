<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Obras\ObrasController;

Route::get('/', function () {
    return session()->get('jwt_token') === null ? view('login') : redirect()->route('home');
});
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth.jwt', 'inject.user'])->group(function () {
    Route::get('/Home', [HomeController::class, 'index'])->name('home');
    Route::get('/Auth/Logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Administração
    Route::prefix('Admin')->middleware('permissao:ADMIN')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // Usuários
        Route::prefix('Usuario')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('admin.usuarios');
            Route::get('/getDados', [UsuarioController::class, 'getDados']);
            Route::get('/editar/{id}', [UsuarioController::class, 'editar'])->name('admin.usuarios.editar');
            Route::post('/cadastrar', [UsuarioController::class, 'store'])->name('admin.usuarios.cadastrar');
        });

        // Obras
        Route::prefix('Obras')->group(function () {
            Route::get('/', [ObrasController::class, 'index'])->name('admin.obras');
            Route::get('/cadastrar', [ObrasController::class, 'create'])->name('admin.obras.cadastrar');
            Route::post('/cadastrar', [ObrasController::class, 'store'])->name('admin.obras.store');
            Route::post('/trocar-obra', [ObrasController::class, 'trocar'])->name('admin.obras.trocar');
            Route::get('/getDados', [ObrasController::class, 'getDados']);
        });
    });
});



