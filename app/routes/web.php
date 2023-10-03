<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordsController;
use App\Http\Controllers\TeamController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/add-password', function () {
    return view('add-password');
})->name('add-password');

Route::post('/post-login', [PasswordsController::class, 'store']);
Route::get('/passwords', [PasswordsController::class, 'getPasswords'])->name('passwords');

Route::get('/password-change/{id}', [PasswordsController::class, 'passwordChangePage'])->name('password-change');
Route::post('/edit-password', [PasswordsController::class, 'editPassword'])->name('edit-password');

Route::get('/create-team', function () {
    return view('create-team');
})->name('create-team');
Route::post('/post-team', [TeamController::class, 'store']);

require __DIR__.'/auth.php';
