<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\WelcomeUserController;
use App\Models\Profession;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// User
Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
Route::post('/usuarios', [UserController::class, 'store']);
Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Profile
Route::get('/editar-perfil', [ProfileController::class, 'edit'])->name('profiles.edit');
Route::put('/editar-perfil', [ProfileController::class, 'update'])->name('profiles.update');

// Professions
Route::get('/profesiones', [ProfessionController::class, 'index'])->name('professions.index');
Route::get('/profesiones/{profession}', [ProfessionController::class, 'show'])->name('professions.show');
Route::get('/profesiones/{profession}/editar', [ProfessionController::class, 'edit'])->name('professions.edit');
Route::put('/profesiones/{profession}', [ProfessionController::class, 'update'])->name('professions.update');
Route::delete('/profesiones/{profession}', [ProfessionController::class, 'destroy'])->name('professions.destroy');

// Skills
Route::get('/habilidades', [SkillController::class, 'index'])->name('skills.index');
Route::delete('/habilidadades/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');


Route::get('/saludo/{name}/{nickname?}', WelcomeUserController::class);
