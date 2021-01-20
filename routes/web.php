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
Route::get('/usuarios/papelera', [UserController::class, 'trashed'])->name('users.trashed');
Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
Route::patch('/usuarios/{user}/papelera', [UserController::class, 'trash'])->name('users.trash');
Route::get('/usuarios/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Profile
Route::get('/editar-perfil', [ProfileController::class, 'edit'])->name('profiles.edit');
Route::put('/editar-perfil', [ProfileController::class, 'update'])->name('profiles.update');

// Professions
Route::get('/profesiones', [ProfessionController::class, 'index'])->name('professions.index');
Route::get('/profesiones/papelera', [ProfessionController::class, 'trashed'])->name('professions.trashed');
Route::get('/profesiones/{profession}', [ProfessionController::class, 'show'])->name('professions.show');
Route::get('/profesiones/{profession}/editar', [ProfessionController::class, 'edit'])->name('professions.edit');
Route::put('/profesiones/{profession}', [ProfessionController::class, 'update'])->name('professions.update');
Route::patch('/profesiones/{profession}/papelera', [ProfessionController::class, 'trash'])->name('professions.trash');
Route::get('/profesiones/{id}/restore', [ProfessionController::class, 'restore'])->name('professions.restore');
Route::delete('/profesiones/{profession}', [ProfessionController::class, 'destroy'])->name('professions.destroy');

// Skills
Route::get('/habilidades', [SkillController::class, 'index'])->name('skills.index');
Route::get('/habilidades/papelera', [SkillController::class, 'trashed'])->name('skills.trashed');
Route::get('/habilidades/{skill}', [SkillController::class, 'show'])->name('skills.show');
Route::get('/habilidades/{skill}/editar', [SkillController::class, 'edit'])->name('skills.edit');
Route::put('/habilidades/{skill}', [SkillController::class, 'update'])->name('skills.update');
Route::patch('/habilidades/{skill}/papelera', [SkillController::class, 'trash'])->name('skills.trash');
Route::get('/habilidades/{id}/restore', [SkillController::class, 'restore'])->name('skills.restore');
Route::delete('/habilidades/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');


Route::get('/saludo/{name}/{nickname?}', WelcomeUserController::class);
