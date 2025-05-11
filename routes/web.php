<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\ResenhaController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FavoritasController;


Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/sobre-cinetria', function () {
    return view('pages.sobre-cinetria');
})->name('sobre-cinetria');

Route::get('/form', function () {
    return view('pages.form');
})->name('form');

Route::post('/{tipo}/detalles/{id}/favorita', [FavoritasController::class, 'toggle'])->name('pelicula.favorita');

Route::get('/{tipo}', [ContenidoController::class, 'abrirPagina'])
    ->whereIn('tipo', ['peliculas', 'series'])
    ->name('contenido');

Route::get('/{tipo}/detalles/{id}', [ContenidoController::class, 'abrirPaginaDetalle']);

// Rutas de persona logeada

Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mi-perfil/editar', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mi-perfil/editar', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mi-perfil', [ProfileController::class, 'index'])->name('mi-perfil');

    Route::get('/resenha/{id}'            , [ResenhaController::class, 'mostrarResenha'])->name('resenhas.mostrar');
    Route::get('/resenha/modificar/{id}' ,  [ResenhaController::class, 'modificarResenha'])->name('resenhas.modificar');
    Route::get('/resenha/eliminar/{id}'   , [ResenhaController::class, 'eliminarResenha'])->name('resenhas.eliminar');
    Route::get('/resenhas/nueva'          , [ResenhaController::class, 'nuevaResenha'])->name('resenhas.nueva');
    Route::post('/resenhas/nueva'         , [ResenhaController::class, 'crearResenha'])->name('resenhas.crear');

    Route::get('/foro', [ResenhaController::class, 'foro'])->name('foro');
    Route::get('/mis-favoritas', [FavoritasController::class, 'showFavoritas'])->name('mis.favoritas');

    Route::delete('mi-perfil/resenhas/delete/{id}', [ResenhaController::class, 'destroy'])->name('admin.resenhas.destroy');
    Route::put('mi-perfil/resenhas/edit/{id}', [ResenhaController::class, 'update'])->name('admin.resenhas.update');


});

// Rutas del dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('pages.dashboard.dashboard');
    })->name('admin');

    Route::get('/admin/users', [DashboardController::class, 'ListaUsuarios'])->name('admin-users');
    Route::put('/admin/users/edit/{user}', [DashboardController::class, 'update']);
    Route::delete('/admin/users/delete/{id}', [DashboardController::class, 'delete'])->name('users.delete');

    Route::get('/admin/resenhas', [DashboardController::class, 'ListaResenhas'])->name('admin-resenhas');
    Route::put('/admin/resenhas/edit/{resenha}', [DashboardController::class, 'updateResenha']);
    Route::delete('/admin/resenhas/delete/{id}', [DashboardController::class, 'deleteResenha']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


require __DIR__.'/auth.php';
