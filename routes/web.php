<?php

use App\Http\Controllers\documentosController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\AdminController;
use GuzzleHttp\Middleware;
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
    return redirect('login');
});


Auth::routes();

Route::middleware('auth')->group(function () {

    //visualizar y crear documentos
    Route::get('/index',[documentosController::class,'index'])->name('documentos.index');
    Route::get('/index/crear',[documentosController::class,'create'])->name('documentos.create');
    Route::post('/index/almacenar',[documentosController::class,'store'])->name('documentos.store');
    
    //editar un documento
    Route::get('/editar/{id}',[documentosController::class, 'edit'])->name('documentos.edit');
    Route::post('/actualizar/{id}',[documentosController::class,'update'])->name('documentos.update');

    Route::patch('/cambiarestado/{id}', [documentosController::class, 'cambiarEstado'])->name('documentos.estado');

    /*
    //Rutas para el admin
    Route::namespace('App\Http\Controller')->prefix('admin')->group(function () {
        //usuarios y sus roles
        Route::get('/',[AdminController::class,'index'])->middleware('can:users.index')->name('admin.index');
        Route::get('/users',[userController::class,'index'])->middleware('can:users.index')->name('admin.users.index');
        Route::get('/user/edit/{id}',[userController::class,'edit'])->middleware('can:users.edit')->name('admin.user.edit');
        Route::post('/user/update/{id}',[userController::class,'update'])->middleware('can:users.edit')->name('admin.user.update');

        //roles y permisos
        Route::get('/roles',[roleController::class,'index'])->middleware('can:users.index')->name('admin.roles.index');
        Route::get('/roles/create',[roleController::class,'create'])->middleware('can:users.index')->name('admin.roles.create');
        Route::post('/roles',[roleController::class,'store'])->middleware('can:users.index')->name('admin.role.store');
        Route::get('/roles/edit/{role}',[roleController::class,'edit'])->middleware('can:users.index')->name('admin.role.edit');
        Route::post('/role/update/{id}',[roleController::class,'update'])->name('admin.role.update');
        Route::get('/role/delete/{role}',[roleController::class,'destroy'])->middleware('can:users.index')->name('admin.role.delete');
    });
    */
    
});