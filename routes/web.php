<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guest\PageController as GuestPageController;

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\TecnologyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');


Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    Route::resource('projects', ProjectController::class);
    Route::resource('types', TypeController::class);
    Route::resource('tecnologies', TecnologyController::class);

    // rotta per la cancellazione delle immagini da edit
    Route::delete('/projects/{project}/delete-image', [ProjectController::class, 'deleteImage'])->name('projects.delete-image');
    // per inviare la mamin al click della checkbox
    Route::patch('/projects/{project}/publish', [ProjectController::class, 'publish'])->name('projects.publish');

  });

require __DIR__ . '/auth.php';