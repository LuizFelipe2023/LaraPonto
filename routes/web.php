<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('funcionarios.index'); 
    }

    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile',[AuthController::class,'profile'])->name('profile')->middleware('auth');
Route::post('/password/update',[AuthController::class,'updatePassword'])->name('password.update')->middleware('auth');

Route::prefix('users')->name('users.')->group(function(){
     Route::get('/painel',[UserController::class,'painelUsuarios'])->name('painel');
     Route::get('/create',[UserController::class,'createUser'])->name('create');
     Route::post('/store',[UserController::class,'storeUser'])->name('store');
     Route::get('/{id}/edit',[UserController::class,'editUser'])->name('edit');
     Route::put('/{id}/update',[UserController::class,'updateUser'])->name('update');
     Route::delete('/{id}/delete',[UserController::class,'deleteUser'])->name('delete');
});

Route::prefix('setores')->name('setores.')->group(function () {
    Route::get('/', [SetorController::class, 'index'])->name('index');
    Route::get('/create', [SetorController::class, 'createSetor'])->name('create');
    Route::post('/store', [SetorController::class, 'storeSetor'])->name('store');
    Route::get('/{id}/edit', [SetorController::class, 'editSetor'])->name('edit');
    Route::put('/{id}/update', [SetorController::class, 'updateSetor'])->name('update');
    Route::delete('/{id}/delete', [SetorController::class, 'deleteSetor'])->name('delete');
});

Route::prefix('funcionarios')->name('funcionarios.')->group(function () {
    Route::get('/painel', [FuncionarioController::class, 'indexFuncionarios'])->name('index');
    Route::get('/create', [FuncionarioController::class, 'createFuncionario'])->name('create');
    Route::post('/store', [FuncionarioController::class, 'storeFuncionario'])->name('store');
    Route::get('/edit/{id}', [FuncionarioController::class, 'editFuncionario'])->name('edit');
    Route::put('/update/{id}', [FuncionarioController::class, 'updateFuncionario'])->name('update');
    Route::delete('/delete/{id}', [FuncionarioController::class, 'deleteFuncionario'])->name('delete');
});