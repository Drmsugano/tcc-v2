<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
// Rotas para autenticação
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login'); })->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/Home', [HomeController::class, 'index'])->name('home');




