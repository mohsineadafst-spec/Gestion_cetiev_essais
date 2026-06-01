<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaboratoireController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\DemandeEssaiController;
use App\Http\Controllers\EtudeController;
use App\Http\Controllers\DemandeConfirmeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion des utilisateurs
    Route::resource('users', UserController::class);

    // Routes pour la gestion des laboratoires
    Route::resource('laboratoires', LaboratoireController::class);

    // Routes pour la gestion des produits
    Route::resource('produits', ProduitController::class);

    // Routes pour la gestion des demandes d'essai
    Route::post('demande_essai/{demande_essai}/cloture', [DemandeEssaiController::class, 'cloture'])->name('demande_essai.cloture');
    Route::get('demande_essai/produit/{produit}', [DemandeEssaiController::class, 'showProduit'])->name('demande_essai.produit.show');
    Route::resource('demande_essai', DemandeEssaiController::class);

    // Routes pour la gestion des demandes confirmées
    Route::resource('demandes_confirmees', DemandeConfirmeeController::class);

    // Routes pour la gestion des études de faisabilité
    Route::get('etudes/{demande}/show', [EtudeController::class, 'show'])->name('etudes.show');
    Route::get('etudes/{demande}/create', [EtudeController::class, 'create'])->name('etudes.create');
    Route::post('etudes/{demande}/store', [EtudeController::class, 'store'])->name('etudes.store');
    Route::get('etudes/{demande}/edit', [EtudeController::class, 'edit'])->name('etudes.edit');
    Route::put('etudes/{demande}/update', [EtudeController::class, 'update'])->name('etudes.update');
});

require __DIR__.'/auth.php';
