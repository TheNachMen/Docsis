<?php

use App\Http\Controllers\documentosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
    return view('auth.login');
});

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/index',[documentosController::class,'index'])->name('documentos.index');
    Route::get('/index/create',[documentosController::class,'create'])->name('documentos.create');
    Route::post('/index',[documentosController::class,'store'])->name('documentos.store');
    
    
    Route::get('/editar/{id}',[documentosController::class, 'edit'])->name('documentos.edit');
    Route::post('/actualizar/{id}',[documentosController::class,'update'])->name('documentos.update');
   

    Route::get('/admin',[App\Http\Controllers\AdminController::class,'index'])->name('admin.index');
    //Route::get('/home', [HomeController::class, 'index'])->name('home');
});