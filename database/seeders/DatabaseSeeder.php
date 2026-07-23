<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Cria as entidades independentes e armazena em coleções
        $themes = Theme::factory(10)->create();
        $publishers = Publisher::factory(15)->create();
        $authors = Author::factory(40)->create();

        // 2. Cria 50 livros reciclando (reutilizando) as editoras e temas já criados acima
        Book::factory(50)
            ->recycle($themes)
            ->recycle($publishers)
            ->create()
            ->each(function (Book $book) use ($authors) {
                // Para cada livro gerado, anexa de 1 a 3 autores aleatórios na tabela pivô
                $randomAuthors = $authors->random(rand(1, 3))->pluck('id');
                $book->authors()->attach($randomAuthors);
            });
    }
}
