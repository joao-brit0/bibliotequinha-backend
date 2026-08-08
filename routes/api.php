<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublisherController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/themes/{themeId}', [BookController::class, 'getByTheme']);
    Route::get('/books/search', [BookController::class, 'getBookByTitle']); 
    Route::get('/authors', [AuthorController::class, 'index']);
});
Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/publishers', [PublisherController::class, 'index']);
Route::post('/publishers', [PublisherController::class, 'store']);
Route::post('/books', [BookController::class, 'store']);
Route::post('/create', [UserController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'login']);

Route::put('/books/{book}', [BookController::class, 'update']);