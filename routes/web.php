<?php

use App\Http\Controllers\FileHandlerController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::resource('todos', TodoController::class)->except(['show']);
    Route::post('/cookiehandler', [TodoController::class, 'setCookie'])->name('todos.setCookie');
    Route::get('/download/{id}', [FileHandlerController::class, 'download'])->name('fileHandler.download');
});
