<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class, 'index']);

Route::post('/books', [BookController::class, 'store']);

Route::put('/books/{book}', [BookController::class, 'update']);