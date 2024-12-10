<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\VerificarSeLogado;
use App\Http\Middleware\VerificarSeNaoLogado;
use Illuminate\Support\Facades\Route;

// rotas do Auth - usuário não logado
Route::middleware([VerificarSeNaoLogado::class])->group(function() {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// rotas do app - usuário logado
Route::middleware([VerificarSeLogado::class])->group(function() {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
