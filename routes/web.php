<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [TodoController::class, 'index']);
Route::post('todos', [TodoController::class, 'store']);
Route::get('fetch-todos', [TodoController::class, 'fetchtodo']);
Route::get('edit-todo/{id}', [TodoController::class, 'edit']);
Route::post('update-todo/{id}', [TodoController::class, 'update']);
Route::delete('delete-todo/{id}', [TodoController::class, 'destroy']);
Route::post('tags', [TagController::class, 'store']);
Route::get('fetch-tags', [TagController::class, 'fetchtag']);

