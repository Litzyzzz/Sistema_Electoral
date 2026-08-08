<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotacionController;
use App\Http\Controllers\ResultadosController;
use App\Http\Middleware\EnsureResultadosAuthenticated;
use App\Http\Controllers\EleccionController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\EnsureEleccionCerrada;
use App\Http\middleware\EnsureVotacionFinalizada;

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

Route::middleware(EnsureVotacionFinalizada::class)->group(function () {
    Route::get('/finalizacion', [VotacionController::class, 'finalizacion'])
        ->name('finalizacion');

}); 

Route::post('/finalizacion/cerrar', [VotacionController::class, 'cerrarFlujo'])
    ->name('finalizacion.cerrar');

Route::middleware(EnsureEleccionCerrada::class)->group(function () {
    Route::get('/resultados', [ResultadosController::class, 'dashboard'])
        ->name('resultados.dashboard');

    Route::get('/resultados/rostro', [ResultadosController::class, 'rostro'])
        ->name('resultados.rostro');

    Route::get('/resultados/bandera', [ResultadosController::class, 'bandera'])
        ->name('resultados.bandera');

});


Route::get('/admin/login', [AdminController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'authenticate'])
    ->name('admin.authenticate');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');

Route::middleware(EnsureResultadosAuthenticated::class)->group(function () {
        Route::get('/admin/control', [AdminController::class, 'control'])
        ->name('admin.control');
            Route::post('/admin/elecciones/{eleccion}/iniciar',[EleccionController::class, 'iniciar'])
        ->name('admin.iniciar-elecciones');
        Route::post('/admin/elecciones/{eleccion}/cerrar',[EleccionController::class, 'cerrarManual'])
        ->name('admin.elecciones.cerrar');
        
});



    
