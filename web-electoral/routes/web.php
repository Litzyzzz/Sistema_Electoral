<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotacionController;

Route::get('/inicio', [VotacionController::class, 'inicio'])
    ->name('inicio');

Route::get('/identificacion', [VotacionController::class, 'identificacion'])
    ->name('identificacion');

Route::post('/identificacion', [VotacionController::class, 'verificarDui'])
    ->name('verificar.dui');
    
Route::get('/verificar-dui', function () {
    return view('verificar-dui');
})->name('verificar.dui');

Route::post('/verificar-dui', [VotacionController::class, 'verificarDui'])->name('verificar.dui.post');

Route::get('/votacion', [VotacionController::class, 'votacion'])
    ->name('votacion');

Route::get('/confirmacion/{id}', [VotacionController::class, 'confirmacion'])->name('confirmacion');

Route::post('/guardar-voto', [VotacionController::class, 'guardarVoto'])->name('guardar.voto');   

Route::post('/votar', [VotacionController::class, 'guardarVoto'])
    ->name('guardar.voto');

Route::get('/finalizacion', [VotacionController::class, 'finalizacion'])
    ->name('finalizacion');    



    
