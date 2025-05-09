<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContenidoController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/sobre-cinetria', function () {
    return view('pages.sobre-cinetria');
})->name('sobre-cinetria');

Route::get('/form', function () {
    return view('pages.form');
})->name('form');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{tipo}', [ContenidoController::class, 'abrirPagina'])
    ->whereIn('tipo', ['peliculas', 'series'])
    ->name('contenido');

Route::get('/{tipo}/detalles/{id}', [ContenidoController::class, 'abrirPaginaDetalle']);

Route::middleware('auth')->group(function () {
    Route::get('/foro', function () {
        return view('pages.foro');
    })->name('foro');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('pages.dashboard.dashboard');
    })->name('admin');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/users', [DashboardController::class, 'ListaUsuarios'])->name('admin-users');
    });

    Route::get('/admin/resenhas/a', function () {
        return view('pages.dashboard.resenhas');
    })->name('admin-resenhas');
});








Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


require __DIR__.'/auth.php';
