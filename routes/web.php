<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContenidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/sobre-cinetria', function () {
    return view('pages.sobre-cinetria');
})->name('sobre-cinetria');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{tipo}', [ContenidoController::class, 'abrirPagina'])
    ->whereIn('tipo', ['peliculas', 'series'])
    ->name('contenido');

Route::get('/peliculas-por-genero', [ContenidoController::class, 'obtenerPeliculasPorGenero']);

Route::get('/{tipo}/{id}', [ContenidoController::class, 'abrirPaginaDetalle']);



require __DIR__.'/auth.php';
