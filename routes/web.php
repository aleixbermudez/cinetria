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

Route::get('/form', function () {
    return view('pages.form');
})->name('form');

Route::get('/perfil', function () {
    return view('pages.perfil');
})->middleware(['auth', 'verified'])->name('perfil');

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

Route::middleware('auth')->group(function () {
    Route::get('/foro', function () {
        return view('pages.foro');
    })->name('foro');
});



require __DIR__.'/auth.php';
