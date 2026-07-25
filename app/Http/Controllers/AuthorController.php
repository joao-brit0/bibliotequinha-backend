<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function __construct(
        protected AuthorService $authorService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $term = $request->query('q');

        if(!$term || strlen($term) < 2) {
            return response()->json(["success" => false, "message" => "O termo de busca deve ter pelo menos 2 caracteres."], 400);
        }

        $authors = $this->authorService->getAllAuthors($term);

        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }
}
