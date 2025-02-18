<?php

use App\Http\Controllers\documentosController;
use App\Http\Controllers\userController;
use App\Http\Controllers\AdminController;
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
   

    Route::get('/admin',[AdminController::class,'index'])->middleware('can:users.index')->name('admin.index');
    Route::get('/admin/users',[userController::class,'index'])->middleware('can:users.index')->name('admin.users.index');
    Route::get('/admin/user/edit/{id}',[userController::class,'edit'])->middleware('can:users.edit')->name('admin.user.edit');
    Route::post('/admin/user/update/{id}',[userController::class,'update'])->middleware('can:users.edit')->name('admin.user.update');

    //Route::get('/home', [HomeController::class, 'index'])->name('home');
});