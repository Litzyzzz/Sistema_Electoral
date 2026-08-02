<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotacionController;
use App\Http\Controllers\ResultadosController;
use App\Http\Middleware\EnsureResultadosAuthenticated;

Route::redirect('/', '/inicio');

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

Route::post('/finalizacion/cerrar', [VotacionController::class, 'cerrarFlujo'])
    ->name('finalizacion.cerrar');

Route::get('/resultados/login', [ResultadosController::class, 'showLogin'])
    ->name('resultados.login');

Route::post('/resultados/login', [ResultadosController::class, 'authenticate'])
    ->name('resultados.authenticate');

Route::post('/resultados/logout', [ResultadosController::class, 'logout'])
    ->name('resultados.logout');

Route::middleware(EnsureResultadosAuthenticated::class)->group(function () {
    Route::get('/resultados', [ResultadosController::class, 'dashboard'])
        ->name('resultados.dashboard');

    Route::get('/resultados/rostro', [ResultadosController::class, 'rostro'])
        ->name('resultados.rostro');

    Route::get('/resultados/bandera', [ResultadosController::class, 'bandera'])
        ->name('resultados.bandera');
});



    
