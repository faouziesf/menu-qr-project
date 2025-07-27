<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route publique pour afficher les menus
Route::get('/menu/{slug}', [PublicController::class, 'showMenu'])->name('public.menu');

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Routes admin protégées
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Gestion des menus (création multi-étapes)
    Route::prefix('admin/menus')->name('admin.menus.')->group(function () {
        // Étape 1 : Type de menu
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/create/step1', [MenuController::class, 'storeStep1'])->name('create.step1');
        
        // Étape 2 : Nom et template
        Route::get('/create/step2', [MenuController::class, 'createStep2'])->name('create.step2');
        Route::post('/create/step2', [MenuController::class, 'storeStep2'])->name('create.step2.store');
        
        // Étape 3 : Contenu
        Route::get('/create/step3', [MenuController::class, 'createStep3'])->name('create.step3');
        Route::post('/create/step3', [MenuController::class, 'store'])->name('store');
        
        // Édition
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });
    
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});