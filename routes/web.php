<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\SetorController;

Route::get('/', [SocioController::class, 'create'])->name('socios.create');
Route::post('/', [SocioController::class, 'store'])->name('socios.store');

Route::get('/dashboard', [SocioController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/socios/{socio}/confirmar', [SocioController::class, 'confirmar'])->name('socios.confirmar');
    Route::delete('/socios/{socio}', [SocioController::class, 'destroy'])->name('socios.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/planos', [PlanoController::class, 'index'])->name('planos.index');
    Route::post('/planos', [PlanoController::class, 'store'])->name('planos.store');
    Route::patch('/planos/{plano}', [PlanoController::class, 'update'])->name('planos.update');
    Route::patch('/planos/{plano}/alternar', [PlanoController::class, 'alternar'])->name('planos.alternar');

    Route::get('/setores', [SetorController::class, 'index'])->name('setores.index');
    Route::post('/setores', [SetorController::class, 'store'])->name('setores.store');
    Route::patch('/setores/{setor}', [SetorController::class, 'update'])->name('setores.update');
    Route::patch('/setores/{setor}/alternar', [SetorController::class, 'alternar'])->name('setores.alternar');
});

Route::get('/idioma/{locale}', function (string $locale) {
    if (in_array($locale, ['pt', 'en'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';
