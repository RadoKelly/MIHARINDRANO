<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProfileController;

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
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::resource('sites', SiteController::class);
});