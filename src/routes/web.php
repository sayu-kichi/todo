<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;

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

Route::get('/',  [TodoController::class, 'index']);

Route::post('/todos',  [TodoController::class, 'store']);

// URL: /todos/update に POSTリクエストが来たら TodoController の update メソッドを実行
Route::patch('/todos/update', [TodoController::class, 'update']);

Route::DELETE('/todos/delete', [TodoController::class, 'destroy']);

Route::get('/todos/search', [TodoController::class, 'search']);

// 一覧表示用
Route::get('/categories', [CategoryController::class, 'index']);
// 保存処理用
Route::post('/categories', [CategoryController::class, 'store']);

Route::patch('/categories/update', [CategoryController::class, 'update']);

Route::DELETE('/categories/delete', [CategoryController::class, 'destroy']);

Route::post('/todos/archive', [TodoController::class, 'archive']);

Route::get('/todos/archived', [TodoController::class, 'archived'])->name('todos.archived');
Route::post('/todos/restore', [TodoController::class, 'restore']); // 元に戻す用