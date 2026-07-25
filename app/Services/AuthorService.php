<?php

namespace App\Services;
use App\Models\Author;

class AuthorService
{
    public function getAllAuthors(string $term)
    {
        return Author::where('name', 'ILIKE', "%{$term}%")
        ->orderBy('name', 'asc')
        ->limit(10) // Trava o máximo de resultados
        ->get(['id', 'name']);
    }
}