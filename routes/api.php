<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/theme/{themeId}', [BookController::class, 'getByTheme']);
Route::get('/authors', [AuthorController::class, 'index']);

Route::post('/books', [BookController::class, 'store']);

Route::put('/books/{book}', [BookController::class, 'update']);