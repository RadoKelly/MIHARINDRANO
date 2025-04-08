<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TarifsController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompteurController;
use App\Http\Controllers\PayementController;
use App\Http\Controllers\ConsommationController;

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

// Redirige la racine vers la page de connexion
Route::redirect('/', '/login');

// Groupe de routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    // Redirection en fonction du rôle de l'utilisateur
    Route::get('/dashboard', function () {
        Log::info('Rôle de l\'utilisateur : ' . auth()->user()->role); // Ajoute un log pour voir la role de l'utilisateur
        if (auth()->user()->role === 'admin') {
            return redirect('/admin-dashboard');
        }
        return redirect('/user-dashboard');
    })->name('dashboard');
    // Tableau de bord admin
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Tableau de bord utilisateur
    Route::get('/user-dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes d'authentification (connexion, inscription, etc.)
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::resource('sites', SiteController::class);
    Route::get('/clients/{client}/compteurs', [ClientController::class, 'getCompteurs']);
    // Route::put('/compteurs/{id}', [CompteurController::class, 'update'])->name('compteurs.update');

    Route::resource('sites/{site}/clients', ClientController::class);
    Route::resource('sites/{site}/compteur', CompteurController::class);
    Route::get('sites/{site}/compteur/create', [CompteurController::class, 'create'])->name('sites.compteur.create');
    Route::post('sites/{site}/compteur', [CompteurController::class, 'store'])->name('compteurs.store');
    Route::resource('sites/{site}/consommation', ConsommationController::class);
    Route::resource('sites/{site}/facture', FactureController::class);
    Route::resource('sites/{site}/payement', PayementController::class);
    Route::resource('sites/{site}/caisse', CaisseController::class);
    Route::resource('sites/{site}/tarifs', TarifsController::class);


    // Ajoute cette route pour la recherche des clients
    Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');

    // Route pour accéder à l'édition d'un compteur pour un site spécifique
    Route::get('sites/{site}/compteur/{compteur}/edit', [CompteurController::class, 'edit'])->name('sites.compteur.edit');

    // Route pour détruire un compteur pour un site spécifique
    Route::delete('sites/{site}/compteur/{compteur}', [CompteurController::class, 'destroy'])->name('sites.compteur.destroy');

    Route::put('/site/{site}/compteurs/{compteur}', [CompteurController::class, 'update'])->name('compteurs.update');

    Route::get('/compteurs/filter', [CompteurController::class, 'getFilteredCompteurs'])->name('compteurs.filter');


});
