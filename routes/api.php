<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/theme/{themeId}', [BookController::class, 'getByTheme']);
    Route::get('/books/search', [BookController::class, 'getBookByTitle']); 
    Route::get('/authors', [AuthorController::class, 'index']);
});

Route::post('/books', [BookController::class, 'store']);
Route::post('/user', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);

Route::put('/books/{book}', [BookController::class, 'update']);