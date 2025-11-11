<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Controle\ControleController;
use App\Http\Controllers\Controle\Epi\EpiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Obras\DocumentacaoObraController;
use App\Http\Controllers\Obras\ObrasController;
use App\Http\Controllers\Controle\Funcionario\FuncionarioController;
use App\Http\Controllers\Controle\Fornecedor\FornecedorController;
use App\Models\DocumentacaoObra;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return session()->get('jwt_token') === null ? view('login') : redirect()->route('home');
    });
    Route::get('/login', fn() => view('login'))->name('login')->middleware('web');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login')->middleware('web');
    Route::middleware(['auth.jwt', 'inject.user'])->group(function () {
        Route::post('/Obras/trocar-obras', [ObrasController::class, 'trocar'])->name('obras.trocar');
        Route::get('/Home', [HomeController::class, 'index'])->name('home');
        Route::get('/Auth/Logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/Meu-Perfil', [UsuarioController::class, 'meuPerfil'])->name('usuario.meu-perfil');
        Route::prefix('Admin')->middleware('permissao:ADMIN')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::prefix('Usuario')->group(function () {
                Route::get('/', [UsuarioController::class, 'index'])->name('admin.usuarios');
                Route::get('/getDados', [UsuarioController::class, 'getDados']);
                Route::get('/editar/{id}', [UsuarioController::class, 'editar'])->name('admin.usuarios.editar');
                Route::post('/cadastrar', [UsuarioController::class, 'store'])->name('admin.usuarios.cadastrar');
            });
            Route::prefix('Obras')->group(function () {
                Route::get('/', [ObrasController::class, 'indexAdmin'])->name('admin.obras');
                Route::get('/cadastrar', [ObrasController::class, 'create'])->name('admin.obras.cadastrar');
                Route::post('/cadastrar', [ObrasController::class, 'store'])->name('admin.obras.store');
                Route::get('/getDados', [ObrasController::class, 'getDados']);
            });
        });
        Route::prefix('Controle')->middleware('permissao:CONTROLE')->group(function () {
            Route::get('/', [ControleController::class, 'index'])->name('controle.index');
            Route::prefix('Obras')->group(function () {
                Route::get('/', [ObrasController::class, 'indexControle'])->name('controle.obras');
                Route::get('/getDados', [ObrasController::class, 'getDados']);
                Route::get('/{id}', [ObrasController::class, 'verDetalhes'])->name('controle.obras.verDetalhes');
            });
            Route::prefix('EPI')->group(function () {
                Route::get('/', [EpiController::class, 'index'])->name('controle.epi');
                Route::get('/getDados', [EpiController::class, 'getDados']);
                Route::get('/{id}', [EpiController::class, 'getEpi'])->name('controle.epi.detalhes');
                Route::post('/store', [EpiController::class, 'store'])->name('controle.epi.store');
                Route::post('/update', [EpiController::class, 'update'])->name('controle.epi.update');
            });
            Route::prefix('Fornecedor')->group(function () {
                Route::get('/', [FornecedorController::class, 'index'])->name('controle.fornecedores');
                Route::get('/getDados', [FornecedorController::class, 'getDados']);
                Route::get('/{id}', [FornecedorController::class, 'getFornecedor'])->name('controle.fornecedores.detalhes');
                Route::post('/store', [FornecedorController::class, 'store'])->name('controle.fornecedores.store');
                Route::post('/update', [FornecedorController::class, 'update'])->name('controle.fornecedores.update');
                Route::post('/delete/{id}', [FornecedorController::class, 'destroy'])->name('controle.fornecedores.destroy');
            });
        });
        Route::prefix('Documentos')->middleware('permissao:CONTROLE')->group(function () {
            Route::prefix('Obras')->group(function () {
                Route::get('/', [DocumentacaoObraController::class, 'indexDocumentos'])->name('documentos.obras');
                Route::get('/getDados', [DocumentacaoObraController::class, 'getDados']);
                Route::get('/{id}', [DocumentacaoObraController::class, 'baixar']);
                Route::get('/{id}/edit', [DocumentacaoObraController::class, 'edit']);
                Route::delete('/delete/{id}', [DocumentacaoObraController::class, 'destroy']);
                Route::post('/update/{id}', [DocumentacaoObraController::class, 'update']);
                Route::post('/store', [DocumentacaoObraController::class, 'store']);
            });
            Route::prefix('Funcionario')->group(function () {
                Route::get('/', [FuncionarioController::class, 'index'])->name('controle.funcionario');
            });
        });
    });
});


