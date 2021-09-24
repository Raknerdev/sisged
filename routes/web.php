<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserController;

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
    return view('auth/login');
});
// GET DATA
Route::get('/get/users', [UserController::class, 'get_users'])->name('get_users');
Route::get('/get/estados', [UserController::class, 'get_estados'])->name('get_estados');
Route::get('/get/internos', [UserController::class, 'get_internos'])->name('get_internos');
Route::get('/get/externos', [UserController::class, 'get_externos'])->name('get_externos');
// Enviadas GET
Route::get('/enviadas', [UserController::class, 'enviados'])->name('enviadas');
// Enviadas POST
Route::post('/add_enviado', [UserController::class, 'add_enviado'])->name('add_enviado');

// Recibidos GET
Route::get('/recibidos', [UserController::class, 'recibidos'])->name('recibidos');
// Recibidos POST
Route::post('/add_recibido', [UserController::class, 'add_recibido'])->name('add_recibido');

// Seguimientos
Route::get('/seguimiento_en/{id}', [UserController::class, 'seguimientos_en'])->name('seguimiento_en');
Route::get('/download_res/{uuid}', [UserController::class, 'download_res'])->name('download_res');
Route::get('/download_env/{uuid}', [UserController::class, 'download_env'])->name('download_env');
Route::get('/seguimiento_re/{id}', [UserController::class, 'seguimientos_re'])->name('seguimiento_re');
Route::get('/print_env/{id}', [UserController::class, 'print_env'])->name('print_env');
Route::get('/print_rec/{id}', [UserController::class, 'print_rec'])->name('print_rec');
Route::post('/add_seguimiento_en/{id}', [UserController::class, 'add_seguimiento_en'])->name('add_seguimiento_en');
Route::post('/add_seguimiento_re/{id}', [UserController::class, 'add_seguimiento_re'])->name('add_seguimiento_re');
