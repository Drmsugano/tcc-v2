<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Obras\ObrasController;

// Rotas para autenticação
Route::get('/', function () {
    return session()->get('jwt_token') === null ? view('login') : redirect()->route('home');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth.jwt', 'inject.user'])->group(function () {
    Route::get('/Home', [HomeController::class, 'index'])->name('home');
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    // Administração
    Route::prefix('Admin')->middleware(['permissao:ADMIN'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        // Usuários
        Route::prefix('Usuario')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('admin.usuarios');
            Route::get('/getDados', [UsuarioController::class, 'getDados']);
            Route::post('/cadastrar', [UsuarioController::class, 'store'])->name('admin.usuarios.cadastrar');
        });
        //Obras
        Route::prefix('Obras')->group(function () {
            Route::get('/', [ObrasController::class, 'index'])->name('admin.obras');
            Route::get('/cadastrar', [ObrasController::class, ''])->name('admin.obras.cadastrar');
            Route::get('/getDados', [ObrasController::class, 'getDados']);
        });
    });
});


