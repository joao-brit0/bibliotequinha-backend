<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Storage;
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

    public function getBookByTitle(Request $request): JsonResponse
    {
        $title = $request->query('title');
        $perPage = $request->query('per_page', 15);

        if (!$title) {
            return response()->json([
                'success' => false,
                'message' => 'O parâmetro "title" é obrigatório.'
            ], 400); // Código HTTP 400: Bad Request
        }

        $books = $this->bookService->getBookByTitle($title, $perPage);

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        // Aciona o Service passando todos os dados recebidos na requisição

        $validatedData = $request->validated();

        $coverPath = null;
    
        if ($request->hasFile('cover_image')) {
            // Salva a imagem na pasta 'covers' dentro do disco público
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

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
            cover_image: $coverPath,
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

        $coverPath = $book->cover_image;

        if ($request->hasFile('cover_image')) {
        // 1. Deleta a imagem antiga do servidor para economizar espaço
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        // 2. Salva a nova imagem
        $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

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
            cover_image: $coverPath,
        );

        $updatedBook = $this->bookService->updateBook($bookDTO, $book);

        return response()->json([
            'success' => true,
            'message' => 'Livro atualizado com sucesso.',
            'data' => $updatedBook
        ]);
    }

    public function getByTheme(Request $request, int $themeId): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        
        $books = $this->bookService->getBookByTheme($themeId, $perPage);

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }
}