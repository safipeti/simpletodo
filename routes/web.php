<?php

use App\Http\Controllers\FileHandlerController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;



Auth::routes();
Route::resource('todos', TodoController::class)->names([
    'create' => 'todos.create',
    'store' => 'todos.store',
    'edit' => 'todos.edit',
    'update' => 'todos.update',
]);
Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::post('/cookiehandler', function (){

    if(!isset($_COOKIE['active_only']))
    {
        setcookie('active_only', true);
    }
    else
    {
        setcookie('active_only', !$_COOKIE['active_only']);
    }



    return redirect('/');

})->name('todos.setCookies');
Route::get('/delete/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');

Route::get('/download/{file_name}', [FileHandlerController::class, 'download'])->name('fileHandler.download');


