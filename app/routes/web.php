<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamPasswordController;


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

//TODO change
//* racine du site
Route::get('/', function () {
    return view('welcome');
});

//TODO change
//* dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//TODO change
//* formulaire d'ajout de mot de passe
Route::get('/add-password', function () {
    return view('add-password');
})->name('add-password');

//* requette d'enregistrement d'un nouveau mot de passe
Route::post('/post-login', [PasswordsController::class, 'store']);

//* requette de récupération des mots de passes de l'utilisateur
Route::get('/passwords', [PasswordsController::class, 'getPasswords'])->name('passwords');

//* page de formulaire de modification d'un mot de passe
Route::get('/password-change/{id}', [PasswordsController::class, 'passwordChangePage'])->name('password-change');

//* requette de modification de mot de passe
Route::post('/edit-password', [PasswordsController::class, 'editPassword'])->name('edit-password');

//TODO change
//* formulaire de création d'équipe
Route::get('/create-team', function () {
    return view('create-team');
})->name('create-team');

//* requette de création de team
Route::post('/post-team', [TeamController::class, 'store']);

//* requette de récupération des mots de passes de l'utilisateur
Route::get('/teams', [TeamController::class, 'getUserTeams'])->name('teams');

//* formulaire d'ajout de membre d'équipe
Route::get('/add-member/{id}', [TeamController::class, 'newTeamMemberPage'])->name('add-member');

//* requette d'ajout d'un membre a une équipe
Route::post('/post-member', [TeamController::class, 'joinTeam']);



//* page de formulaire de d'ajout de mot de passe d'équipe
Route::get('/add-team-password/{id}', [TeamPasswordController::class, 'newPasswordPage'])->name('add-team-password');

//* requette de d'ajout de mot de passe d'équipe
Route::post('/post-team-password', [TeamPasswordController::class, 'createTeamPassword'])->name('post-team-password');

require __DIR__.'/auth.php';
