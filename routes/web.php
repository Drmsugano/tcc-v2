<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsuarioController;
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

Route::middleware(['auth.jwt', 'inject.user'])->group(function () {
    Route::get('/Home', [HomeController::class, 'index'])->name('home');
    // Administração
    Route::prefix('Admin')->middleware(['permissao:ROSFIELD_ADMIN'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        // Usuários
        Route::prefix('Usuario')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('admin.usuarios');
            Route::get('/getDados', [UsuarioController::class, 'getDados']);
            Route::post('/cadastrar', [UsuarioController::class, 'cadastrar'])->name('admin.usuarios.cadastrar');
        });

    });
});


