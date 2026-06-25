<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaboratoireController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\DemandeEssaiController;
use App\Http\Controllers\EtudeController;
use App\Http\Controllers\DemandeConfirmeeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ActionLogController;
use App\Http\Controllers\PlanifierController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.index');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Demandes confirmées
    Route::get('demandes_confirmees/select-produit', [DemandeConfirmeeController::class, 'selectProduit'])
        ->name('demandes_confirmees.select');
    Route::get('demandes_confirmees/create', [DemandeConfirmeeController::class, 'create'])
        ->name('demandes_confirmees.create');
    Route::resource('demandes_confirmees', DemandeConfirmeeController::class)->except(['create']);

    // Chat
    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // Produits
    Route::resource('produits', ProduitController::class);

    // Demandes d'essai
    Route::post('demande_essai/{demande_essai}/cloture', [DemandeEssaiController::class, 'cloture'])->name('demande_essai.cloture');
    Route::get('demande_essai/produit/{produit}', [DemandeEssaiController::class, 'showProduit'])->name('demande_essai.produit.show');
    Route::resource('demande_essai', DemandeEssaiController::class);

    // Planifications
    Route::resource('planifier', PlanifierController::class);

    // Études de faisabilité
    Route::get('etudes/{demande}/show', [EtudeController::class, 'show'])->name('etudes.show');
    Route::get('etudes/{demande}/create', [EtudeController::class, 'create'])->name('etudes.create');
    Route::post('etudes/{demande}/store', [EtudeController::class, 'store'])->name('etudes.store');
    Route::get('etudes/{demande}/edit', [EtudeController::class, 'edit'])->name('etudes.edit');
    Route::put('etudes/{demande}/update', [EtudeController::class, 'update'])->name('etudes.update');

    // 🔒 Routes réservées au Root
    Route::middleware(\App\Http\Middleware\IsRoot::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('laboratoires', LaboratoireController::class);
        Route::get('/logs', [ActionLogController::class, 'index'])->name('logs.index');
        Route::delete('/logs/{id}', [ActionLogController::class, 'destroy'])->name('logs.destroy');
    });
});

require __DIR__.'/auth.php';
