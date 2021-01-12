<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeUserController;


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
Route::get('/editar-perfil/', [ProfileController::class, 'edit']);
Route::put('/editar-perfil/', [ProfileController::class, 'update']);


Route::get('/saludo/{name}/{nickname?}', WelcomeUserController::class);
