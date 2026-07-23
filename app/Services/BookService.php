<?php

namespace App\Services;

use App\Models\Book;
use App\DTOs\BookDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BookService
{
    /**
     * Retorna a lista paginada de livros para a página inicial do catálogo.
     */
    public function getCatalogHome(int $perPage = 15): LengthAwarePaginator
    {
        // A consulta utilizando o Eloquent ORM é feita diretamente no Service
        return Book::with(['authors', 'publisher', 'theme'])
            ->orderBy('title', 'asc')
            ->paginate($perPage);
    }

    public function registerBook(BookDTO $dto): Book
    {
        return DB::transaction(function () use ($dto) {
            // Cria o registro do livro usando os dados permitidos
            $book = Book::create([
                'title' => $dto->title,
                'subtitle' => $dto->subtitle,
                'publication_year' => $dto->publication_year,
                'publisher_id' => $dto->publisher_id,
                'theme_id' => $dto->theme_id,
                'isbn' => $dto->isbn,
                'quantity' => $dto->quantity,
                'number_of_pages' => $dto->number_of_pages,
                'cutter_code' => $dto->cutter_code,
                'description' => $dto->description,
            ]);

            $book->authors()->attach($dto->authors);

            // Retorna o livro já carregando os relacionamentos para a resposta da API
            return $book->load(['authors', 'publisher', 'theme']);
        });
    }
}