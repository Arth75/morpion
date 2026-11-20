<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartieController;

Route::get('/parties', [PartieController::class, 'index']);

Route::get('/', [PartieController::class, 'index'])->name('parties.index');
Route::post('/parties', [PartieController::class, 'store'])->name('parties.store');
Route::get('/parties/{partie}', [PartieController::class, 'show'])->name('parties.show');
Route::post('/parties/{partie}/coups', [PartieController::class, 'jouer'])->name('parties.jouer');
Route::delete('/parties/{partie}/coups/dernier', [PartieController::class, 'annuler'])->name('parties.annuler')
?>