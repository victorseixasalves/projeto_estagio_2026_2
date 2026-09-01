<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SocioController::class, 'create'])->name('socios.create');
Route::post('/', [SocioController::class, 'store'])->name('socios.store');

Route::get('/dashboard', [SocioController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/idioma/{locale}', function (string $locale) {
    if (in_array($locale, ['pt', 'en'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';
