<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\DTOs\BookDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    public function index(Request $request): JsonResponse
    {
        // Captura o parâmetro 'per_page' da URL, ou utiliza 15 como padrão
        $perPage = $request->query('per_page', 15);
        
        // Aciona a regra de negócio centralizada no Service
        $books = $this->bookService->getCatalogHome($perPage);

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        // Aciona o Service passando todos os dados recebidos na requisição

        $validatedData = $request->validated();

        $bookDTO = new BookDTO(
            title: $validatedData['title'],
            publisher_id: $validatedData['publisher_id'],
            theme_id: $validatedData['theme_id'],
            isbn: $validatedData['isbn'],
            authors: $validatedData['authors'],
            subtitle: $validatedData['subtitle'] ?? null,
            publication_year: $validatedData['publication_year'] ?? null,
            quantity: $validatedData['quantity'] ?? 1,
            number_of_pages: $validatedData['number_of_pages'] ?? null,
            cutter_code: $validatedData['cutter_code'] ?? null,
            description: $validatedData['description'] ?? null,
        );

        $book = $this->bookService->registerBook($bookDTO);

        return response()->json([
            'success' => true,
            'message' => 'Livro catalogado com sucesso no acervo.',
            'data' => $book
        ], 201); // Código HTTP 201: Created
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $validatedData = $request->validated();

        $bookDTO = new BookDTO(
            title: $validatedData['title'],
            publisher_id: $validatedData['publisher_id'],
            theme_id: $validatedData['theme_id'],
            isbn: $validatedData['isbn'],
            authors: $validatedData['authors'],
            subtitle: $validatedData['subtitle'] ?? null,
            publication_year: $validatedData['publication_year'] ?? null,
            quantity: $validatedData['quantity'] ?? 1,
            number_of_pages: $validatedData['number_of_pages'] ?? null,
            cutter_code: $validatedData['cutter_code'] ?? null,
            description: $validatedData['description'] ?? null,
        );

        $updatedBook = $this->bookService->updateBook($bookDTO, $book);

        return response()->json([
            'success' => true,
            'message' => 'Livro atualizado com sucesso.',
            'data' => $updatedBook
        ]);
    }
}