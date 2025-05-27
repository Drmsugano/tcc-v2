<?php

use Illuminate\Support\Facades\Route;
// Rotas para autenticação
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/auth/login', 'Auth\AuthController@login')->name('auth.login');
Route::post('/auth/logout', 'Auth\AuthController@logout')->name('auth.logout');




