<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PontoController;
use App\Http\Controllers\AtrasoController;
use App\Http\Controllers\FaltaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/painel', [UserController::class, 'painelUsuarios'])->name('painel');
            Route::get('/create', [UserController::class, 'createUser'])->name('create');
            Route::post('/store', [UserController::class, 'storeUser'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'editUser'])->name('edit');
            Route::put('/{id}/update', [UserController::class, 'updateUser'])->name('update');
            Route::delete('/{id}/delete', [UserController::class, 'deleteUser'])->name('delete');
        });


        Route::prefix('setores')->name('setores.')->group(function () {
            Route::get('/', [SetorController::class, 'index'])->name('index');
            Route::get('/create', [SetorController::class, 'createSetor'])->name('create');
            Route::post('/store', [SetorController::class, 'storeSetor'])->name('store');
            Route::get('/{id}/edit', [SetorController::class, 'editSetor'])->name('edit');
            Route::put('/{id}/update', [SetorController::class, 'updateSetor'])->name('update');
            Route::delete('/{id}/delete', [SetorController::class, 'deleteSetor'])->name('delete');
        });
    });

    Route::middleware([CheckRole::class])->group(function () {
        Route::prefix('funcionarios')->name('funcionarios.')->group(function () {
            Route::get('/painel', [FuncionarioController::class, 'indexFuncionarios'])->name('index');
            Route::get('/create', [FuncionarioController::class, 'createFuncionario'])->name('create');
            Route::post('/store', [FuncionarioController::class, 'storeFuncionario'])->name('store');
            Route::get('/edit/{id}', [FuncionarioController::class, 'editFuncionario'])->name('edit');
            Route::put('/update/{id}', [FuncionarioController::class, 'updateFuncionario'])->name('update');
            Route::delete('/delete/{id}', [FuncionarioController::class, 'deleteFuncionario'])->name('delete');
        });

        Route::prefix('pontos')->name('pontos.')->group(function () {
            Route::get('/', [PontoController::class, 'index'])->name('index');
            Route::delete('/{id}', [PontoController::class, 'deletePonto'])->name('delete');
        });

        Route::prefix('faltas')->name('faltas.')->group(function () {
            Route::get('/', [FaltaController::class, 'index'])->name('index');
            Route::get('/create', [FaltaController::class, 'create'])->name('create');
            Route::post('/store', [FaltaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [FaltaController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [FaltaController::class, 'update'])->name('update');
            Route::delete('/{id}', [FaltaController::class, 'destroy'])->name('destroy');
            Route::get('/pdf',[FaltaController::class,'pdfFaltas'])->name('pdf');
        });

        Route::prefix('atrasos')->name('atrasos.')->group(function () {
            Route::get('/', [AtrasoController::class, 'index'])->name('index');
            Route::get('/create', [AtrasoController::class, 'create'])->name('create');
            Route::post('/store', [AtrasoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AtrasoController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [AtrasoController::class, 'update'])->name('update');
            Route::delete('/{id}', [AtrasoController::class, 'destroy'])->name('destroy');
            Route::get('/pdf',[AtrasoController::class,'pdfAtrasos'])->name('pdf');
        });
    });

    Route::prefix('pontos')->name('pontos.')->group(function () {
        Route::get('/entrada/{funcionarioId}', [PontoController::class, 'createEntrada'])->name('createEntrada');
        Route::post('/entrada/{funcionarioId}', [PontoController::class, 'storeEntrada'])->name('storeEntrada');
        Route::get('/saida/{funcionarioId}', [PontoController::class, 'createSaida'])->name('createSaida');
        Route::post('/saida/{pontoId}', [PontoController::class, 'storeSaida'])->name('storeSaida');
        Route::get('/funcionario/{id}', [PontoController::class, 'pontosFuncionario'])->name('funcionario');
        Route::get('/funcionario/{id}/pdf', [PontoController::class, 'pdfPontosFuncionario'])->name('pdfFuncionario');
        Route::get('/funcionarios/pdf-geral', [PontoController::class, 'pdfPontosGeral'])->name('pdfGeral');
    });
});
